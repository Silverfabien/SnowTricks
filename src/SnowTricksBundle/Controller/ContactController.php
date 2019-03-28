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

        if ($form->isSubmitted() && $form->isValid()) {
            $contactMail = $this->getParameter('contact_email');
            $data = $form->getData();
            $message = \Swift_Message::newInstance("le sujet du contact est " . $data["sujet"])
                ->setFrom($this->getParameter('mailer_user'))
                ->setTo(array($contactMail))
                ->setBody($data["contenu"] . "\r\n\r\nEmail :" . $data["email"]);
            $this->get('mailer')->send($message);
            return $this->redirectToRoute('snowtricks_contact');
        }

        return $this->render('@SnowTricks/Default/contact.html.twig', ['form' => $form->createView()]);
    }
}