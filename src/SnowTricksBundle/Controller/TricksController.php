<?php

namespace SnowTricksBundle\Controller;

use SnowTricksBundle\Entity\Comment;
use SnowTricksBundle\Entity\Tricks;
use SnowTricksBundle\Form\CommentType;
use SnowTricksBundle\Form\TricksType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class TricksController extends Controller
{
    /**
     * @Route("/{page}", requirements={"page" = "\d+"}, name="snowtricks_homepage")
     */
    public function indexAction($page = 1)
    {
        $maxPerPage = 8;

        $em = $this->getDoctrine()->getManager();
        $tricks = $em->getRepository('SnowTricksBundle:Tricks')->getAllPosts($page, $maxPerPage);

        $totalPosts = $tricks->count();

        return $this->render('@SnowTricks/Default/index.html.twig', ['pagination' => [
            'nbPages' => (int) ceil($totalPosts / $maxPerPage),
            'currentPage' => (int) $page,
            'tricks' => $tricks
        ]]);
    }

    /**
     * @Route("/tricks/{slug}/{page}", name="snowtricks_viewtricks")
     */
    public function viewAction(Request $request, Tricks $tricks, UserInterface $user = null, $slug, $page = 1)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $comment->setTrick($tricks);
            $comment->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('snowtricks_viewtricks', ['slug' => $slug]);
        }

        $em = $this->getDoctrine()->getManager();
        $comments = $em->getRepository('SnowTricksBundle:Comment')->findBy(['trick' => $tricks]);

        $tricks = $this->getDoctrine()->getRepository(Tricks::class)->findOneBy(['slug' => $slug]);

        return $this->render('@SnowTricks/tricks/view.html.twig', ['trick' => $tricks, 'addCommentForm' => $form->createView(), 'comments' => $comments]);
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
            $em = $this->getDoctrine()->getManager();

            $toKeep = $request->request->get('picture_to_keep', []);

            foreach($tricks->getPictures() as $picture)
            {
                if(!in_array($picture->getId(), array_merge($toKeep, [null])))
                {
                    $tricks->removePicture($picture);
                    $em->remove($picture);
                }
            }

            $em->flush();

            return $this->redirectToRoute('snowtricks_viewtricks', ['slug' => $tricks->getSlug()]);
        }

        return $this->render("@SnowTricks/tricks/edit.html.twig", ['tricks' => $tricks, 'editTricksForm' => $form->createView()]);
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