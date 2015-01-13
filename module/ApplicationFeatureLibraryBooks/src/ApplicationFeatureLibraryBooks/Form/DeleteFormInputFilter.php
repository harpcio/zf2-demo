<?php
/**
 * This file is part of Zf2-demo package
 *
 * @author Rafal Ksiazek <harpcio@gmail.com>
 * @copyright Rafal Ksiazek F.H.U. Studioars
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApplicationFeatureLibraryBooks\Form;

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