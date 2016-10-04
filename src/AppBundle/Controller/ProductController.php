<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    /**
     * @Route("/", name="listproduct")
     */
    public function indexAction()
    {
        $products = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->findBy(array(),null,5,0);
        return $this->render('products/index.html.twig',array('products'=>$products));
    }

    /**
     * @Route("/new/", name="newproduct")
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isValid()) {
            // perform some action...
            $p = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($p);
            $em->flush();

            $this->addFlash(
                'message',
                'El producto se ha guardado!!!'
            );

            return $this->redirectToRoute('listproduct');
        }

        return $this->render('products/new.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @Route("/edit/{id}", name="editproduct")
     */
    public function editAction(Request $request,$id)
    {

        $product = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->find($id);

        if (!$product)
        {
            throw $this->createNotFoundException('No se encontro el producto.');
        }

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isValid()) {
            // perform some action...
            $p = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($p);
            $em->flush();

            $this->addFlash(
                'message',
                'El producto se ha modificado y guardado!!!'
            );

            return $this->redirectToRoute('listproduct');
        }

        return $this->render('products/edit.html.twig', array(
            'form'=>$form->createView(),
            'product'=>$product
        ));
    }

    /**
     * @Route("/delete/{id}", name="deleteproduct")
     */
    public function deleteAction(Request $request,$id)
    {
        $product = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->find($id);

        if (!$product)
        {
            throw $this->createNotFoundException('No se encontro el producto.');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        $this->addFlash(
            'message',
            'El producto se ha guardado!!!'
        );

        return $this->redirectToRoute('listproduct');
    }
}
