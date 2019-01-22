<?php

namespace SnowTricksBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SnowTricksBundle\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    /** Gestion des utilisateurs */

    public function accountAction()
    {

    }

    public function createDeleteForm()
    {

    }

    public function deleteUserAction()
    {

    }

    public function editUserAction()
    {

    }

    public function newUserAction()
    {

    }

    /** Connexion / Déconnexion / Inscription */

    /**
     * @Route("/login", name="snowtricks_login")
     */
    public function loginAction()
    {
        $loginForm = $this->createForm(LoginType::class, ['username' => $this->get('security.authentication_utils')->getLastUsername()]);

        return $this->render('@SnowTricks/user/login.html.twig', ['loginForm' => $loginForm->createView()]);
    }

    public function logoutAction()
    {

    }

    public function registerAction()
    {

    }
}