<?php
/**
 * Created by PhpStorm.
 * User: JAGUILAR
 * Date: 8/9/2017
 * Time: 4:47 PM
 */
namespace AppBundle\Admin;

use AppBundle\Entity\BlogPost;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class BlogPostAdmin extends AbstractAdmin
{
    public $supportsPreviewMode = true;

    protected function configureFormFields(FormMapper $formMapper)
    {
        /*$formMapper
            ->add('title', 'text')
            ->add('body', 'textarea')
            ->add('category', 'sonata_type_model', array(
                'class' => 'AppBundle\Entity\Category',
                'property' => 'name',
            ))

        ;*/
        $formMapper
            ->with('Content', array('class' => 'col-md-9'))
                ->add('title', 'text')
                ->add('body', 'textarea')
            ->end()

            ->with('Meta data', array('class' => 'col-md-3'))
                ->add('category', 'sonata_type_model', array(
                    'class' => 'AppBundle\Entity\Category',
                    'property' => 'name',
            ))
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('body')
            ->add('category.name')
            //->add('draft', 'boolean')
            // editable association field
            ->add('draft', 'choice', array(
                'editable' => true,
                'choices' => array(
                    1 => 'Active',
                    0 => 'Inactive'
                ),
                'label' => 'Status'
            ))
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                ),
                'header_class' => 'customActions',
                'row_align' => 'center'
            ))
        ;
    }

    public function toString($object)
    {
        return $object instanceof BlogPost
            ? $object->getTitle()
            : 'Blog Post'; // shown in the breadcrumb on the create view
    }


    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', null, array(
                'show_filter' => true,
                'advanced_filter' => false
            ))
            ->add('category', null, array(
                    'show_filter' => true,
                    'advanced_filter' => false
                ),
                'entity', array(
                    'class'    => 'AppBundle\Entity\Category',
                    'choice_label' => 'name', // In Symfony2: 'property' => 'name'
            ))
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title')
            ->add('slug')
            ->add('author')
        ;
    }

}