<?php

namespace Module\LibraryBooks\Service\SLFactory;

use BusinessLogic\Books\Repository\BooksRepository;
use Module\LibraryBooks\Service\CrudService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CrudServiceSLFactory implements FactoryInterface
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
         * @var $bookRepository BooksRepository
         */
        $bookRepository = $serviceLocator->get(BooksRepository::class);

        return new CrudService($bookRepository);
    }
}
