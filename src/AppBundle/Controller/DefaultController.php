<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    /**
     * @param $campo
     */
    public function validarCampos($campo)
    {
        $campoConstraint = new Assert\Email();
        $campoConstraint->message = "Correo Invalido";

        $error = $this->get('validator')->validate(
            $campo,
            $campoConstraint
        );

        if($error == 0){
            echo "Correo Valido";
        }else{
            echo $error[0]->getMessage();
        }
        die();
    }
}
