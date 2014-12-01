<?php

namespace BusinessLogic\Users\Repository\SLFactory;

use Doctrine\ORM\EntityManager;
use BusinessLogic\Users\Entity\UserEntity;
use BusinessLogic\Users\Repository\UsersRepository;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UsersRepositorySLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return UsersRepository
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var $em              EntityManager
         * @var $usersRepository UsersRepository
         */
        $em = $serviceLocator->get(EntityManager::class);
        $usersRepository = $em->getRepository(UserEntity::class);

        return $usersRepository;
    }
}