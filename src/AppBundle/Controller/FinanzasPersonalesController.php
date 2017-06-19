<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FinanzasPersonales;
use AppBundle\Form\FinanzasPersonalesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/finance")
 */
class FinanzasPersonalesController extends Controller
{

    /**
     * @Route("/", name="listFP")
     */
    public function listAction(){

    }

    /**
     * @Route("/add/", name="addFP")
     */
    public function addAction(Request $request)
    {
        $finanzasPersonales = new FinanzasPersonales();
        $form = $this->createForm(FinanzasPersonalesType::class, $finanzasPersonales);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->get('app.repository.finance')->save($finanzasPersonales);

            $this->addFlash('success', sprintf(
                'El %s, con el detalle %s!',
                $finanzasPersonales->getTipoFpId()->getNombre(),
                $finanzasPersonales->getCategoriaFpId()->getNombre()
            ));

            return $this->redirectToRoute('listFP');
        }

        return $this->render('finances/new.html.twig', array(
            'form'=>$form->createView()
        ));
    }
}
