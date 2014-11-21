<?php

namespace Auth\Service\SLFactory;

use Auth\Service\LogoutService;
use Auth\Service\Storage\DbStorage;
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
        /** @var \Auth\Service\Storage\DbStorage $storage */
        $storage = $serviceLocator->get(DbStorage::class);
        $authService = new AuthenticationService($storage);

        return new LogoutService($authService);
    }
}