<?php

namespace Module\Auth\Service\SLFactory;

use Module\Auth\Service\LogoutService;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogoutServiceSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return LogoutService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var AuthenticationService $authService
         */
        $authService = $serviceLocator->get(AuthenticationService::class);

        return new LogoutService($authService);
    }
}