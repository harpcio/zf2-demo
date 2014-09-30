<?php

namespace Library\Service\Book\Factory;

use Library\Repository\BookRepository;
use Library\Service\Book\CrudService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CrudServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return CrudService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var $bookRepository BookRepository
         */
        $bookRepository = $serviceLocator->get(BookRepository::class);

        return new CrudService($bookRepository);
    }
}
