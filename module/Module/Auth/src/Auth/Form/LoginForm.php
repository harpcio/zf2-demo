<?php

namespace Module\Auth\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class LoginForm extends Form
{
    public function __construct($name = 'loginForm', array $options = null)
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
                'name' => 'login',
                'type' => Element\Text::class,
                'options' => [
                    'label' => 'User name / email:',
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'required' => 'required',
                ],
            ]
        );

        $this->add(
            [
                'name' => 'password',
                'type' => Element\Password::class,
                'options' => [
                    'label' => 'Password:',
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
                'type' => Element\Csrf::class,
            ]
        );

        $this->add(
            [
                'name' => 'submit',
                'type' => Element\Submit::class,
                'attributes' => [
                    'class' => 'btn btn-default btn-lg',
                    'type' => 'submit',
                    'value' => 'Login'
                ],
            ]
        );
    }

}