<?php

namespace Module\Auth\Service\SLFactory;

use Module\Auth\Service\Storage\DbStorage;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class AuthenticationServiceSLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return AuthenticationService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var DbStorage $storage
         */
        $storage = $serviceLocator->get(DbStorage::class);

        return new AuthenticationService($storage);
    }
}