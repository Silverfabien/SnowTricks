<?php

namespace SnowTricksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TricksController extends Controller
{
    /**
     * @Route("/", name="snowtricks_homepage")
     */
    public function indexAction()
    {
        return $this->render('@SnowTricks/Default/index.html.twig');
    }

    /**
     * @Route("/tricks/{slug}", name="snowtricks_viewtricks")
     */
    public function viewAction()
    {

    }

    /** Gestion des Tricks */

    /**
     * @Route("/add/tricks", name="snowtricks_addtricks")
     */
    public function addAction()
    {

    }

    /**
     * @Route("/edit/tricks/{slug}", name="snowtricks_edittricks")
     */
    public function editAction()
    {

    }

    /**
     * @Route("/delete/tricks/{slug}", name="snowtricks_deletetricks")
     */
    public function deleteAction()
    {

    }
}