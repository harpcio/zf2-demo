<?php

namespace Application\Library\QueryFilter\SLFactory;

use Application\Library\QueryFilter\Command;
use Application\Library\QueryFilter\QueryFilter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class QueryFilterSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return QueryFilter
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new QueryFilter(
            [
                new Command\Special\SortCommand(),
                new Command\Special\LimitCommand(),
                new Command\Special\OffsetCommand(),
            ],
            [
                new Command\Criteria\BetweenCommand(),
                new Command\Criteria\MinMaxCommand(),
                new Command\Criteria\StartsEndsWithCommand(),
                new Command\Criteria\EqualCommand(),
                new Command\Criteria\InArrayCommand() // this must the last command
            ]
        );
    }
}