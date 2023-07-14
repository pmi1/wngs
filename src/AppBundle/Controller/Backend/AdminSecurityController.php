<?php

namespace AppBundle\Controller\Backend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Админ-контроллер. Точка входа/выхода в админку
 */
class AdminSecurityController extends Controller
{
    /**
     * @Route("/admin/login", name="admin_login")
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('admin/admin_login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
    
    /**
     * @Route("/admin/logout", name="admin_logout")
     */
    public function logoutAction()
    {
    }
}
