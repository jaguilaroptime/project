<?php

namespace AppBundle\Form;

use AppBundle\Form\Type\GenderType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
            //->add('category',TextType::class, array('label'=>'Categoria'))
            ->add('category',EntityType::class,array(
                'class'=>'AppBundle\Entity\ProductCategory',
                'choice_label' => 'name',
                'placeholder' => 'Seleccionar',
            ))
            ->add('price',NumberType::class, array('label'=>'Precio'))
            ->add('img', FileType::class, array(
                'label' => 'Imagen (PNG file)',
                "attr" =>array("class" => "form-control"),
                "data_class" => null
            ))
            ->add('gender_code', GenderType::class, array(
                'placeholder' => 'Choose a gender',
            ))
            ;
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
