<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FinanzasPersonalesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tipoFpId',EntityType::class,array(
            'class'=>'AppBundle\Entity\TipoFP',
            'choice_label' => 'nombre',
            'placeholder' => 'Seleccionar',
            ))
            ->add('categoriaFpId',EntityType::class,array(
                'class'=>'AppBundle\Entity\CategoriaFP',
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccionar',
            ))
            ->add('valor',TextType::class, array('label'=>'Valor'))
            ->add('nota',TextareaType::class, array('label'=>'Detalle'));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        /*
        $resolver->setDefaults(array(
            'data_class' => 'AppBunle\Entity\FinanzasPersonales'
        ));*/
    }

    public function getName()
    {
        return 'app_bundle_finanzas_personales_type';
    }
}
