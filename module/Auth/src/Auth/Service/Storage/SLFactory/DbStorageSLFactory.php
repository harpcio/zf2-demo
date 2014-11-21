<?php

namespace Auth\Service\Storage\SLFactory;

use Auth\Service\Storage\DbStorage;
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
     * @return \Auth\Service\Storage\DbStorage
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \User\Repository\UserRepository $userRepository */
        $userRepository = $serviceLocator->get(UserRepository::class);

        return new DbStorage($userRepository);
    }
}