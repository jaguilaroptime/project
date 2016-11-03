<?php

namespace ExampleBundle\Controller;

use ExampleBundle\Entity\ProductCategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/product-cat")
 */
class ProductCategoryController extends Controller
{
    /**
     * @Route("/list/", name="product_category_list" )
     */
    public function indexAction()
    {
        $categories = $this
            ->getDoctrine()
            ->getRepository(ProductCategory::class)
            ->findAllActives();
        return $this->render('@Example/product/list.html.twig',[
            'categories' => $categories
        ]);
    }
}
