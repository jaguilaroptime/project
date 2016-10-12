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
     * @Route("/list", name="listproduct1")
     */
    public function indexAction(Request $request)
    {

        $form = $this->createForm(ProductSearchType::class);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $formData = $request->get($form->getName());

            $code = $formData['code'];
            $name = $formData['name'];

            $products = $this->getDoctrine()
                ->getRepository('AppBundle:Product')
                ->findByParams(array('code'=>$code, 'name'=>$name));
        }else{
            $products = $this->getDoctrine()
                ->getRepository('AppBundle:Product')
                ->findAll();
        }

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('products/index.html.twig',array('pagination'=>$pagination,'form'=>$form->createView()));
    }

    /**

     * @Route("/", name="listproduct")

     */

    public function listAction(Request $request)

    {
        /*$products = $this->get('app.repository.product')
            ->getQueryBuilderForAll($request->query->get('search'))
            ->getQuery();*/
        $products = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->getQueryBuilderForAll($request->query->get('search'));

        //$products->setHydrationMode(Query::HYDRATE_ARRAY);

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
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
            // perform some action...
            $p = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($p);
            $em->flush();

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

        if ($form->isSubmitted() && $form->isValid()) {
            // perform some action...
            $p = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($p);
            $em->flush();

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
