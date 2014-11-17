<?php

namespace Library\Service\Book\Factory;

use Application\Library\QueryFilter\Command;
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

        $commandCollection = new Command\Repository\CommandCollection(
            [
                // condition
                new Command\Repository\BetweenCommand(),
                new Command\Repository\StartsWithCommand(),
                new Command\Repository\EndsWithCommand(),
                new Command\Repository\MinCommand(),
                new Command\Repository\MaxCommand(),
                new Command\Repository\EqualCommand(),
                new Command\Repository\InArrayCommand(),
                // special
                new Command\Repository\FieldsCommand(),
                new Command\Repository\SortCommand(),
                new Command\Repository\LimitCommand(),
                new Command\Repository\OffsetCommand(),
            ]
        );

        return new FilterResultsService($bookRepository, $commandCollection);
    }
}
