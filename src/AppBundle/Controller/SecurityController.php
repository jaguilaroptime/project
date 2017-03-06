<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security_login")
     */
    public function indexAction()
    {
        /*
        $encoder = $this->get('security.password_encoder');
        $usuario = $this->get('doctrine.orm.default_entity_manager')->find(User::class,1);

        $pass = $encoder->encodePassword($usuario,'Optime123');

        $usuario->setPassword($pass);

        $usuario->setPassword($pass);
        $this->get('doctrine.orm.default_entity_manager')->flush($usuario);
        dump('se cambio el password');die();*/



        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('Security/login.html.twig',[
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
    }
}
