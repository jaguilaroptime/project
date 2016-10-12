<?php
/**
 * Class Product
 * User: JAGUILAR
 * Date: 29/09/2016
 */
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Product;
use Doctrine\ORM\QueryBuilder;


class ProductRepository extends EntityRepository
{
    /**
     * Busca todos los productos de acuerdo a los parametros definidos
     * @param array $parameters
     * @return array
     */
    public function findByParams(array $parameters)
    {
        $dql = "
          SELECT p
          FROM AppBundle:Product p WHERE 1=1";

        if(!empty($parameters['code']))
        {
            $dql .= " AND p.code =:code";
        }
        if(!empty($parameters['name']))
        {
            $dql .= " AND p.name LIKE :name";
        }

        $query = $this->getEntityManager()->createQuery($dql);

        if(!empty($parameters['code']))
        {
            $query->setParameter('code', $parameters['code'] );
        }
        if(!empty($parameters['name']))
        {
            $query->setParameter('name', '%'. $parameters['name']. '%');
        }

        $products = $query->getResult();
        return $products;
    }

    /**
     * Busca todos los productos de acuerdo a los parametros definidos
     * @param string|null $search = parametros de busqueda
     * @return QueryBuilder
     */

    public function getQueryBuilderForAll($search = null)
    {
        $query = $this->createQueryBuilder('product');
         //   ->addSelect('category')
         //   ->leftJoin('product.category', 'category');

        if(is_string($search) and !empty($search)){
            $query->andWhere($query->expr()->orX(
                'product.code = :search',
                'product.name LIKE :search_like',
                'product.description LIKE :search_like'
            ))->setParameters([
                'search' => $search,
                'search_like' => '%'.$search.'%',
            ]);
        }
        return $query;
    }

}