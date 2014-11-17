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
                new Command\Special\FieldsCommand(),
                new Command\Special\SortCommand(),
                new Command\Special\LimitCommand(),
                new Command\Special\OffsetCommand(),
                new Command\Condition\BetweenCommand(),
                new Command\Condition\MinMaxCommand(),
                new Command\Condition\StartsEndsWithCommand(),
                new Command\Condition\EqualCommand(),
                new Command\Condition\InArrayCommand() // this must the last command
            ]
        );
    }
}