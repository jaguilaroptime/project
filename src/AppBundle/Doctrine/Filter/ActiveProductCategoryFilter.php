<?php

namespace AppBundle\Doctrine\Filter;

use AppBundle\Entity\ProductCategory;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class ActiveProductCategoryFilter extends SQLFilter
{

    public function addFilterConstraint(ClassMetadata $meta, $alias)
    {
        $class = $meta->getName();
        if(ProductCategory::class !== $class){
            return '';
        }
        return $alias.'.active = true';
    }
}