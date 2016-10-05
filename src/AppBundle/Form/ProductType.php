<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('code', TextType::class, array('label'=>'Código'))
            ->add('name',TextType::class, array('label'=>'Nombre'))
            ->add('description',TextareaType::class, array('label'=>'Descripción'))
            ->add('trademark',TextType::class, array('label'=>'Marca'))
            ->add('category',TextType::class, array('label'=>'Categoria'))
            ->add('price',NumberType::class, array('label'=>'Precio'))
            ->add('save', SubmitType::class, array('label' => 'Guardar','attr' => array('class' => 'btn btn-primary pull-right')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Product'
        ));
    }

    public function getName()
    {
        return 'app_bundle_product';
    }
}
