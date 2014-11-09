<?php

namespace Auth\Controller\SLFactory;

use Auth\Controller\LoginController;
use Auth\Form\LoginForm;
use Auth\Service\LoginService;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LoginControllerSLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return LoginController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ControllerManager $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();

        /**
         * @var $form    LoginForm
         * @var $service LoginService
         */
        $form = $serviceLocator->get(LoginForm::class);
        $service = $serviceLocator->get(LoginService::class);

        return new LoginController($form, $service);
    }
}