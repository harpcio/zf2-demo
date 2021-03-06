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

namespace ApplicationFeatureAccess\Form;

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
                    'placeholder' => 'default: admin',
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
                    'placeholder' => 'default: admin',
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