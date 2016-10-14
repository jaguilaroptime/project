<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Form\ProductSearchType;
use AppBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Query;

/**
* @Route("/product")
*/
class ProductController extends Controller
{
    /**
     * @Route("/", name="listproduct")
     */
    public function listAction(Request $request)

    {
        $products = $this->get('app.repository.product')
            ->getQueryBuilderForAll($request->query->get('search'))
            ->getQuery();
        /*$products = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->getQueryBuilderForAll($request->query->get('search'));*/

        $products->setHydrationMode(Query::HYDRATE_ARRAY);

        $pagination = $this->get('knp_paginator')->paginate(
            $products,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('products/index.html.twig',array('pagination'=>$pagination));
    }

    /**
     * @Route("/new/", name="newproduct")
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->get('app.repository.product')->save($product);

            $this->addFlash('success', sprintf(
                'El producto con el código %s se ha creado con éxito!',
                $product->getCode()
            ));

            return $this->redirectToRoute('listproduct');
        }

        return $this->render('products/new.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    /**
     * @Route("/edit/{id}/", name="editproduct")
     */
    public function editAction(Request $request, Product $product)
    {

        if (!$product)
        {
            throw $this->createNotFoundException('No se encontro el producto.');
        }

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->get('app.repository.product')->save($product);
            $this->addFlash('success', sprintf(
                'El producto con el código %s se ha actualizado con éxito!',
                $product->getCode()
            ));

            return $this->redirectToRoute('listproduct');
        }

        return $this->render('products/edit.html.twig', array(
            'form'=>$form->createView(),
            'product'=>$product
        ));
    }

    /**
     * @Route("/delete/{id}/", name="deleteproduct")
     */
    public function deleteAction(Product $product)
    {
        if (!$product)
        {
            throw $this->createNotFoundException('No se encontro el producto.');
        }

        $this->get('app.repository.product')->delete($product);

        $this->addFlash('success', sprintf(
            'El producto con el código %s se ha eliminado con éxito!',
            $product->getCode()
        ));

        return $this->redirectToRoute('listproduct');
    }
}
