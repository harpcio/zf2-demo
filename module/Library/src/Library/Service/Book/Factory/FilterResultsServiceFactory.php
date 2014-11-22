<?php

namespace Library\Service\Book\Factory;

use Application\Library\QueryFilter\Command\Repository;
use Library\Repository\BookRepository;
use Library\Service\Book\FilterResultsService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FilterResultsServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return FilterResultsService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var $bookRepository BookRepository
         */
        $bookRepository = $serviceLocator->get(BookRepository::class);
        $commandCollection = $serviceLocator->get(Repository\CommandCollection::class);

        return new FilterResultsService($bookRepository, $commandCollection);
    }
}
