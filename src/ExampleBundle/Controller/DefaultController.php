<?php

namespace ExampleBundle\Controller;

use ExampleBundle\Form\ExampleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/example")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/new/",name="new_example")
     */
    public function indexAction(Request $request)
    {

        $form = $this->createForm(ExampleType::class,[
            'profesion' => 'Sirva',
        ],[
            'paises_adicionales' => [
                'Mexico' => 'MX',
                'Puerto Rico' => 'PR'
            ]
        ]);

        $form->handleRequest($request);

        $form->isSubmitted(); dump($form->getData());
        return $this->render('@Example/Default/new.html.twig', array(
            'form'=>$form->createView()
        ));
    }
}
