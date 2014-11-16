<?php

namespace Library\Service\Book\Factory;

use Application\Library\Repository\Command;
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

        $commandCollection = new Command\CommandCollection(
            [
                new Command\BetweenCommand(),
                new Command\StartsWithCommand(),
                new Command\EndsWithCommand(),
                new Command\MaxCommand(),
                new Command\MinCommand(),
                new Command\EqualCommand(),
                new Command\InArrayCommand()
            ]
        );

        return new FilterResultsService($bookRepository, $commandCollection);
    }
}
