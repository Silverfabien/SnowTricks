<?php

namespace SnowTricksBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SnowTricksBundle\Entity\User;
use SnowTricksBundle\Form\ForgotPasswordType;
use SnowTricksBundle\Form\LoginType;
use SnowTricksBundle\Form\RegisterType;
use SnowTricksBundle\Form\ResetPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class UserController extends Controller
{
    /** Gestion des utilisateurs */

    /**
     * @Route("/account/{username}", name="snowtricks_account")
     */
    public function accountAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('@SnowTricks/user/account.html.twig');
    }

    /**
     * @Route("/account/{username}", name="snowtricks_account")
     */
    public function editUserAction(Request $request, UserInterface $userConnected)
    {
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($userConnected->getId());
        $edit = $this->createForm(RegisterType::class, $user);
        $edit->handleRequest($request);

        if ($edit->isSubmitted() && $edit->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute("snowtricks_account", ['username' => $user->getUsername()]);
        }

        return $this->render('@SnowTricks/user/account.html.twig', ['user' => $user, 'editForm' => $edit->createView()]);
    }

    /** Connexion / Déconnexion / Inscription */

    /**
     * @Route("/login", name="snowtricks_login")
     */
    public function loginAction()
    {
        $form = $this->createForm(LoginType::class, ['username' => $this->get('security.authentication_utils')
            ->getLastUsername()]);

        return $this->render('@SnowTricks/user/login.html.twig', ['loginForm' => $form->createView()]);
    }

    /**
     * @Route("/logout", name="snowtricks_logout")
     * @throws \Exception
     */
    public function logoutAction()
    {
        throw new \Exception('This should not be reached');
    }

    /**
     * @Route("/register", name="snowtricks_register")
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->get('security.authentication.guard_handler')->authenticateUserAndHandleSuccess(
                $user, $request, $this->get('user.security.login_form_authenticator'), 'main'
            );
        }

        return $this->render('@SnowTricks/user/register.html.twig', ['user' => $user, 'registerForm' => $form->createView()]);
    }

    /**
     * @Route("/forgot-password", name="snowtricks_forgot_password")
     */
    public function forgottenPasswordAction(Request $request, TokenGeneratorInterface $tokenGenerator, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->getData()['email'];

            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->findOneByEmail($email);

            /* @var $user User */
            if($user === null) {
                $this->addFlash('success', 'Votre email a été envoyé si celle-ci est existante dans nos services');
                return $this->redirectToRoute('snowtricks_forgot_password');
            }

            $token = $tokenGenerator->generateToken();

            try {
                $user->setResetToken($token);
                $user->setResetTokenCreatedAt(new \DateTime());
                $entityManager->flush();
            } catch (\Exception $exception) {
                $this->addFlash('warning', $exception->getMessage());
                return $this->redirectToRoute('snowtricks_forgot_password');
            }

            $url = $this->generateUrl('snowtricks_reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

            $message = (new \Swift_Message('Forgot password'))
                ->setFrom($this->getParameter('mailer_user'))
                ->setTo($user->getEmail())
                ->setBody('<p>Bonjour</p>
                                 <p>Vous nous avez demandé un lien pour reset votre mot de passe, voici le lien 
                                 : <a href="'.$url.'">'.$url.'</a></p>
                                 <p>Cordialement,</p>
                                 <p>Le site SnowTricks</p>', 'text/html');

            $mailer->send($message);

            $this->addFlash('success', 'Votre email a été envoyé si celle-ci est existante dans nos services');

            return $this->redirectToRoute('snowtricks_forgot_password');
        }

        return $this->render('@SnowTricks/user/forgotPassword.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/reset-password/{token}", name="snowtricks_reset_password")
     */
    public function resetPasswordAction(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneByResetToken($token);

        /* @var $user User */
        if($user === null) {
            $this->addFlash('danger', 'Le lien que vous avez demandé n\'existe pas!');
            return $this->redirectToRoute('snowtricks_homepage');
        }

        if ($request->isMethod('POST')) {
            $user->setResetToken(null);
            $user->setResetTokenCreatedAt(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $entityManager->flush();

            $this->addFlash('success', 'Le mot de passe a bien été mis à jour!');

            return $this->redirectToRoute('snowtricks_homepage');
        }

        return $this->render('@SnowTricks/user/resetPassword.html.twig', ['token' => $token]);
    }
}