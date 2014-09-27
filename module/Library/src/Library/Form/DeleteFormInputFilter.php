<?php

namespace Library\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

class DeleteFormInputFilter extends InputFilter
{
    public function __construct()
    {
        $factory = new InputFactory();

        $this->add(
            $factory->createInput(
                [
                    'name' => 'id',
                    'required' => true,
                    'filters' => [
                        ['name' => 'Digits'],
                    ],
                    'validators' => [
                        [
                            'name' => 'GreaterThan',
                            'options' => [
                                'encoding' => 'UTF-8',
                                'min' => 0,
                                'inclusive' => false,
                            ],
                        ],
                    ],
                ]
            )
        );

    }
}