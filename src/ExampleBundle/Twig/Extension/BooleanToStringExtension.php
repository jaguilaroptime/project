<?php

namespace ExampleBundle\Twig\Extension;

use Symfony\Component\Translation\TranslatorInterface;

class BooleanToStringExtension extends \Twig_Extension
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function getFilters(){
        return array(
            new \Twig_SimpleFilter('boolean_to_string', [$this, 'booleanToString']),
        );
    }

    public function booleanToString($value){
        if(true == $value){
            return $this->translator->trans('label.yes');
        }else{
            return $this->translator->trans('label.no');
        }
    }
    public function getName()
    {
        return 'boolean_to_string';
    }
}