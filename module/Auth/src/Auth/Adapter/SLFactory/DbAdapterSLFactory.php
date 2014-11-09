<?php

namespace Auth\Adapter\SLFactory;

use Auth\Adapter\DbAdapter;
use User\Repository\UserRepository;
use Zend\Crypt\Password\Bcrypt;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DbAdapterSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return DbAdapter
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \User\Repository\UserRepository $userRepository */
        $userRepository = $serviceLocator->get(UserRepository::class);
        $passwordCrypt = new Bcrypt();

        return new DbAdapter($userRepository, $passwordCrypt);
    }
}