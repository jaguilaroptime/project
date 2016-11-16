<?php
namespace AppBundle\EventListener;

class DisableProductCategoryFilterListener
{
    private $em;
    private $checker;

    public function __construct($em, $checker)
    {
        $this->em = $em;
        $this->checker = $checker;
    }

    public function onKernelRequest($event)
    {
        $path = $event->getRequest()->getPathInfo();

        if(preg_match('@^/(_(profiler|wdt)|css|images|js)/@', $path)){
            return;
        }
        if ($this->checker->isGranted('ROLE_ADMIN'))
        {
            $this->em->getFilters()->disable('active_product_category');
            return true;
        }
        return false;
    }
}