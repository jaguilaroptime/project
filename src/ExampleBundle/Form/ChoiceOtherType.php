<?php

namespace ExampleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoiceOtherType extends AbstractType implements DataTransformerInterface
{
    private $choices = [];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->choices = $options['opciones_select'];

        $builder->add('select', ChoiceType::class, [
            'label' => false,
            'choices' => $options['opciones_select'],
        ]);

        $builder->add('text', TextType::class, [
            'label' => false,
        ]);

        $builder->addModelTransformer($this);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('opciones_select');
        $resolver->setAllowedTypes('opciones_select', 'array');
        $resolver->setNormalizer('opciones_select',function ($opciones, $valor)
        {
           return $valor + [
               'Especificar Otra Opcion' => '__OTHER__',
           ];
        });

    }

    public function transform($value)
    {
        if(null == $value){
           return $value;
        }

        $data = [
            'select' => '__OTHER__',
            'text' => ''
        ];
        if(in_array($value, $this->choices)){
            $data['select'] = $value;
        }else{
            $data['text'] = $value;
        }
        return $data;
    }

    public function reverseTransform($value)
    {
        if('__OTHER__' == $value['select']){
            return $value['text'];
        }
        return $value['select'];
    }
}
