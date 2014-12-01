<?php

namespace Module\Auth\Service\Storage\SLFactory;

use Module\Auth\Service\Storage\DbStorage;
use BusinessLogic\Users\Repository\UsersRepository;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DbStorageSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return \Module\Auth\Service\Storage\DbStorage
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var UsersRepository $userRepository */
        $userRepository = $serviceLocator->get(UsersRepository::class);

        return new DbStorage($userRepository);
    }
}