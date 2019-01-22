<?php

namespace SnowTricksBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SnowTricksBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="snowtricks_contact")
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $contactMail = $this->getParameter('contact_email');
            $data = $form->getData();
            $message = \Swift_Message::newInstance("le sujet du contact est ". $data["sujet"])
                ->setFrom(array($contactMail => "Message envoyé par ". $data["nom"]))
                ->setTo(array($contactMail => $contactMail))
                ->setBody($data["contenu"]. "<br>Email :" .$data["email"]);
            $this->get('mailer')->send($message);
            dump($data);
            die();
            return $this->redirectToRoute('snowtricks_contact');
        }

        return $this->render('@SnowTricks/Default/contact.html.twig', ['form' => $form->createView()]);
    }
}