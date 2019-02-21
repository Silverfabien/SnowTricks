<?php

namespace SnowTricksBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SnowTricksBundle\Entity\User;
use SnowTricksBundle\Form\ForgotPasswordType;
use SnowTricksBundle\Form\LoginType;
use SnowTricksBundle\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
    public function editUserAction(Request $request, User $user)
    {
        $edit = $this->createForm(RegisterType::class, $user);
        $edit->handleRequest($request);

        if($edit->isSubmitted() && $edit->isValid())
        {
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
        $form = $this->createForm(LoginType::class, ['username' => $this->get('security.authentication_utils')->getLastUsername()]);

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

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('snowtricks_login', ['id' => $user->getId()]);
        }

        return $this->render('@SnowTricks/user/register.html.twig', ['user' => $user, 'registerForm' => $form->createView()]);
    }
}