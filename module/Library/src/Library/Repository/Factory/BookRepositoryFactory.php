<?php

namespace Library\Repository\Factory;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Library\Entity\BookEntity;
use Library\Repository\BookRepository;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BookRepositoryFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return BookRepository
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var $em             EntityManager
         * @var $bookRepository BookRepository
         */
        $em = $serviceLocator->get(EntityManager::class);
        $bookRepository = $em->getRepository(BookEntity::class);
        $hydrator = new DoctrineObject($em, BookEntity::class);
        $bookRepository->setHydrator($hydrator);

        return $bookRepository;
    }
}