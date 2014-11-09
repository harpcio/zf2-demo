<?php

namespace Auth\Storage\SLFactory;

use Auth\Storage\DbStorage;
use User\Repository\UserRepository;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DbStorageSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return DbStorage
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \User\Repository\UserRepository $userRepository */
        $userRepository = $serviceLocator->get(UserRepository::class);

        return new DbStorage($userRepository);
    }
}