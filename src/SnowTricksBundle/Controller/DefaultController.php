<?php

namespace SnowTricksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="snowtricks_index")
     */
    public function indexAction()
    {
        return $this->render('@SnowTricks/Default/index.html.twig');
    }
}