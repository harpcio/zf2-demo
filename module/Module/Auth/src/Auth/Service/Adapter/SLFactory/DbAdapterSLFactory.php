<?php

namespace Module\Auth\Service\Adapter\SLFactory;

use Module\Auth\Service\Adapter\DbAdapter;
use BusinessLogic\Users\Repository\UsersRepository;
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
        /** @var UsersRepository $userRepository */
        $userRepository = $serviceLocator->get(UsersRepository::class);
        $passwordCrypt = new Bcrypt();

        return new DbAdapter($userRepository, $passwordCrypt);
    }
}