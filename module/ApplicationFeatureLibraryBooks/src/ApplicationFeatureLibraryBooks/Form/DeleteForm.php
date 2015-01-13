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

use Zend\Form\Form;

class DeleteForm extends Form
{
    public function __construct($name = 'deleteForm', array $options = null)
    {
        parent::__construct($name, $options);

        $this->setAttributes(
            [
                'enctype' => 'multipart/form-data',
                'method' => 'post',
                'id' => $name,
                'role' => 'form'
            ]
        );

        $this->add(
            [
                'name' => 'id',
                'type' => 'Zend\Form\Element\Hidden',
            ]
        );

        $this->add(
            [
                'name' => 'csrf',
                'type' => 'Zend\Form\Element\Csrf',
            ]
        );

        $this->add(
            [
                'name' => 'submit',
                'type' => 'Zend\Form\Element\Submit',
                'attributes' => [
                    'class' => 'btn btn-default btn-lg',
                    'type' => 'submit',
                    'value' => 'Delete'
                ],
            ]
        );
    }

}