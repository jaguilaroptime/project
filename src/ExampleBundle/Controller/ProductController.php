<?php

namespace ExampleBundle\Controller;

use ExampleBundle\Gateway\ProductGateway;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/prod")
 */
class ProductController extends Controller
{
    /**
     * @Route("/list/", name="product_list" )
     */
    public function indexAction()
    {
        //Desactivar desde el controlador el filtro
        //$em = $this->getDoctrine()->getManager();
        //$em->getFilters()->disable('active_product_category');

        //$productGateway = new ProductGateway($em);
        $productGateway = $this->get('app.gateway.product');

        return $this->render('@Example/product/list_product.html.twig',[
            'products' => $productGateway->getAll()
        ]);
    }
}
