<?php

namespace Auth\Service\SLFactory;

use Auth\Adapter\DbAdapter;
use Auth\Service\LoginService;
use Auth\Storage\DbStorage;
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
        /** @var \Auth\Storage\DbStorage $storage */
        $storage = $serviceLocator->get(DbStorage::class);
        /** @var \Auth\Adapter\DbAdapter $authAdapter */
        $authAdapter = $serviceLocator->get(DbAdapter::class);
        $authService = new AuthenticationService($storage);

        return new LoginService($authService, $authAdapter);
    }
}