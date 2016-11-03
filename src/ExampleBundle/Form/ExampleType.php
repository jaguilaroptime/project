<?php

namespace ExampleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExampleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $paises = [
            'Colombia' => 'CO',
            'Venezuela' => 'VE',
            'Brasil' => 'BR'
        ];

        if(isset($options['paises_adicionales']))
        {
            $paises = $paises + $options['paises_adicionales'];
        }

        $builder->add('nombre',TextType::class, array('label'=>'nombre'))
                ->add('profesion', ChoiceOtherType::class, [
                    'opciones_select' => [
                        'Programador' => 'PROG',
                    ]
                ])
                ->add('pais',ChoiceType::class, array(
                    'placeholder' => 'Seleccione Pais',
                    'choices' => $paises
                ))
                ->add('estado',ChoiceType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined('paises_adicionales');
        $resolver->setAllowedTypes('paises_adicionales', 'array');
    }

}
