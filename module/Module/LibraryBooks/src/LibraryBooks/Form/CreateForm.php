<?php

namespace Module\LibraryBooks\Form;

use Zend\Form\Form;

class CreateForm extends Form
{
    public function __construct($name = 'bookForm', array $options = null)
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
                'name' => 'title',
                'type' => 'Zend\Form\Element\Text',
                'options' => [
                    'label' => 'Title:',
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'required' => 'required',
                ],
            ]
        );

        $this->add(
            [
                'name' => 'description',
                'type' => 'Zend\Form\Element\Textarea',
                'options' => [
                    'label' => 'Description: ',
                ],
                'attributes' => [
                    'class' => 'form-control'
                ],
            ]
        );

        $this->add(
            [
                'name' => 'isbn',
                'type' => 'Zend\Form\Element\Text',
                'options' => [
                    'label' => 'ISBN:',
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'required' => 'required',
                ]
            ]
        );

        $this->add(
            [
                'name' => 'year',
                'type' => 'Zend\Form\Element\Text',
                'options' => [
                    'label' => 'Publishing year:',
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'required' => 'required',
                ],
            ]
        );

        $this->add(
            [
                'name' => 'publisher',
                'type' => 'Zend\Form\Element\Text',
                'options' => [
                    'label' => 'Publisher:',
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'required' => 'required',
                ],
            ]
        );

        $this->add(
            [
                'name' => 'price',
                'type' => 'Zend\Form\Element\Text',
                'options' => [
                    'label' => 'Price:',
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'required' => 'required',
                ],
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
                    'value' => 'Submit'
                ],
            ]
        );
    }

}