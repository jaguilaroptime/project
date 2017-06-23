<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
 
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class AjaxController extends Controller
{
    /**
     * @Route("/ajax")
     */
    public function indexAction()
    {
        return $this->render('ajax/index.html.twig', array(

        ));
    }
    
    /**
     * @Route("/ajax/posts", name="ajax_posts")
     * @Method({"GET"})
     */
    public function postsAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
 
            $serializer = new Serializer($normalizers, $encoders);
 
            $posts =  $this->get('app.repository.product')->findByParams(array());
            
            //dump($posts);die();
            $response = new JsonResponse();
            $response->setStatusCode(200);
            $response->setData(array(
                'response' => 'success',
                'posts' => $serializer->serialize($posts, 'json')
            ));
            return $response;
        }
    }
}