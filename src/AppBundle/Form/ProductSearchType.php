<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('code', TextType::class, array('label'=>'Código','required' => false, 'attr'=>array('class' => 'form-control')))
            ->add('name',TextType::class, array('label'=>'Nombre', 'required' => false, 'attr'=>array('class' => 'form-control')))
            ->add('search', SubmitType::class, array('label' => 'Buscar','attr' => array('class' => 'btn btn-primary pull-right')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'app_bundle_product_search_type';
    }
}
