<?php

namespace Module\Auth\Form\SLFactory;

use Module\Auth\Form\LoginForm;
use Module\Auth\Form\LoginFormInputFilter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LoginFormSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return LoginForm
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var $filter LoginFormInputFilter
         */
        $filter = $serviceLocator->get(LoginFormInputFilter::class);

        $form = new LoginForm();
        $form->setInputfilter($filter);

        return $form;
    }
}