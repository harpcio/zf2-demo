<?php

namespace Module\Auth\Service\SLFactory;

use Module\Auth\Service\Adapter\DbAdapter;
use Module\Auth\Service\LoginService;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LoginServiceSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return LoginService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var DbAdapter             $authAdapter
         * @var AuthenticationService $authService
         */
        $authAdapter = $serviceLocator->get(DbAdapter::class);
        $authService = $serviceLocator->get(AuthenticationService::class);

        return new LoginService($authService, $authAdapter);
    }
}