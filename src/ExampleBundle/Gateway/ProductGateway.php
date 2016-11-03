<?php

namespace ExampleBundle\Gateway;

use Doctrine\ORM\EntityManagerInterface;

class ProductGateway
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAll()
    {
        /*$dql = <<<DQL
SELECT
    p.id,p.name,p.description, p_cat.name category,p_cat.active,
    CASE WHEN p_cat.premiun = true THEN 'Si' ELSE 'No' END is_premiun
FROM ExampleBundle:Product p
JOIN p.category p_cat
DQL;*/
        $dql = <<<DQL
SELECT
    p.id,p.name,p.description, p_cat.name category, p_cat.active, p_cat.premiun
FROM ExampleBundle:Product p
JOIN p.category p_cat
DQL;

        $query = $this->entityManager->createQuery($dql);
        return $query->getResult();
    }
}