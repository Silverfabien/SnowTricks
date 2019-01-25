<?php

namespace SnowTricksBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use SnowTricksBundle\Entity\Tricks;
use SnowTricksBundle\Form\TricksType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class TricksController extends Controller
{
    /**
     * @Route("/", name="snowtricks_homepage")
     */
    public function indexAction()
    {
        $tricks = $this->getDoctrine()->getManager()->getRepository(Tricks::class);
        $trick = $tricks->findAll();

        return $this->render('@SnowTricks/Default/index.html.twig', ['tricks' => $trick]);
    }

    /**
     * @Route("/tricks/{slug}", name="snowtricks_viewtricks")
     */
    public function viewAction($slug)
    {
        $trick = $this->getDoctrine()->getRepository(Tricks::class)->findOneBy(['slug' => $slug]);

        return $this->render('@SnowTricks/tricks/view.html.twig', ['trick' => $trick]);
    }

    /** Gestion des Tricks */

    /**
     * @Route("/add/tricks", name="snowtricks_addtricks")
     */
    public function addAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $tricks = new Tricks();
        $form = $this->createForm(TricksType::class, $tricks);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tricks);
            $em->flush();

            return $this->redirectToRoute('snowtricks_homepage');
        }

        return $this->render('@SnowTricks/tricks/add.html.twig', ['addTricksForm' => $form->createView()]);
    }

    /**
     * @Route("/edit/tricks/{slug}", name="snowtricks_edittricks")
     */
    public function editAction(Request $request, Tricks $tricks)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $form = $this->createForm(TricksType::class, $tricks);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('snowtricks_viewtricks', ['slug' => $tricks->getSlug()]);
        }

        return $this->render("@SnowTricks/tricks/edit.html.twig", ['editTricksForm' => $form->createView()]);
    }

    /**
     * @Route("/delete/tricks/{slug}", name="snowtricks_deletetricks")
     */
    public function deleteAction(Request $request, Tricks $tricks)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $form = $this->createDeleteForm($tricks);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $deleteForm = $this->getDoctrine()->getManager();
            $deleteForm->remove($tricks);
            $deleteForm->flush();

            return $this->redirectToRoute('snowtricks_homepage');
        }

        return $this->render('@SnowTricks/tricks/delete.html.twig', ['deleteTricksForm' => $form->createView()]);
    }

    public function createDeleteForm(Tricks $tricks)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('snowtricks_deletetricks', ['slug' => $tricks->getSlug()]))
            ->setMethod('DELETE')
            ->getForm();
    }
}