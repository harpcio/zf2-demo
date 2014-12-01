<?php

namespace Module\Auth\Controller\SLFactory;

use Module\Auth\Controller\LogoutController;
use Module\Auth\Service\LogoutService;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogoutControllerSLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return LogoutController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ControllerManager $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();

        /**
         * @var $service LogoutService
         */
        $service = $serviceLocator->get(LogoutService::class);

        return new LogoutController($service);
    }
}