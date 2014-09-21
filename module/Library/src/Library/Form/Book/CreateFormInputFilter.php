<?php

namespace Library\Form\Book;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

class CreateFormInputFilter extends InputFilter
{
    public function __construct()
    {
        $factory = new InputFactory();

        $this->add(
            $factory->createInput(
                [
                    'name'       => 'title',
                    'required'   => true,
                    'filters'    => [
                        ['name' => 'StripTags'],
                        ['name' => 'StringTrim'],
                    ],
                    'validators' => [
                        [
                            'name'    => 'StringLength',
                            'options' => [
                                'encoding' => 'UTF-8',
                                'min'      => 3,
                                'max'      => 255,
                            ],
                        ],
                    ],
                ]
            )
        );

        $this->add(
            $factory->createInput(
                [
                    'name'       => 'description',
                    'required'   => false,
                    'filters'    => [
                        ['name' => 'StripTags'],
                        ['name' => 'StringTrim'],
                    ],
                    'validators' => [],
                ]
            )
        );

        $this->add(
            $factory->createInput(
                [
                    'name'       => 'isbn',
                    'required'   => true,
                    'filters'    => [
                        ['name' => 'StripTags'],
                        ['name' => 'StringTrim'],
                    ],
                    'validators' => [
                        [
                            'name'    => 'Isbn',
                            'options' => [
                                'separator' => '-'
                            ]
                        ]
                    ],
                ]
            )
        );

        $this->add(
            $factory->createInput(
                [
                    'name'       => 'year',
                    'required'   => true,
                    'filters'    => [
                        ['name' => 'Digits'],
                        ['name' => 'StringTrim'],
                    ],
                    'validators' => [
                        [
                            'name'    => 'GreaterThan',
                            'options' => [
                                'encoding'  => 'UTF-8',
                                'min'       => 1900,
                                'inclusive' => true,
                            ],
                        ],
                        [
                            'name'    => 'LessThan',
                            'options' => [
                                'encoding'  => 'UTF-8',
                                'max'       => date('Y'),
                                'inclusive' => true,
                            ],
                        ],
                    ],
                ]
            )
        );

        $this->add(
            $factory->createInput(
                [
                    'name'       => 'publisher',
                    'required'   => true,
                    'filters'    => [
                        ['name' => 'StripTags'],
                        ['name' => 'StringTrim'],
                    ],
                    'validators' => [
                        [
                            'name'    => 'StringLength',
                            'options' => [
                                'encoding' => 'UTF-8',
                                'min'      => 3,
                                'max'      => 255,
                            ],
                        ],
                    ],
                ]
            )
        );
        $this->add(
            $factory->createInput(
                [
                    'name'       => 'price',
                    'required'   => true,
                    'validators' => [
                        [
                            'name'    => 'Regex',
                            'options' => [
                                'pattern'  => '/^[0-9]+([\.|,]{1}[0-9]*)?$/',
                                'messages' => [
                                    'regexNotMatch' => 'The input does not appear to be a valid float number'
                                ]
                            ],
                        ]
                    ],
                ]
            )
        );

    }
}