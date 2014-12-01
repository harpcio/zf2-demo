<?php

namespace BusinessLogic\Books\Repository\SLFactory;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use BusinessLogic\Books\Entity\BookEntity;
use BusinessLogic\Books\Repository\BooksRepository;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BooksRepositorySLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return BooksRepository
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var $em              EntityManager
         * @var $booksRepository BooksRepository
         */
        $em = $serviceLocator->get(EntityManager::class);
        $booksRepository = $em->getRepository(BookEntity::class);
        $hydrator = new DoctrineObject($em, BookEntity::class);
        $booksRepository->setHydrator($hydrator);

        return $booksRepository;
    }
}