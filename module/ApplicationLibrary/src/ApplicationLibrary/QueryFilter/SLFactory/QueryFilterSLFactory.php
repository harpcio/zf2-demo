<?php
/**
 * This file is part of Zf2-demo package
 *
 * @author Rafal Ksiazek <harpcio@gmail.com>
 * @copyright Rafal Ksiazek F.H.U. Studioars
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApplicationLibrary\QueryFilter\SLFactory;

use ApplicationLibrary\QueryFilter\Command;
use ApplicationLibrary\QueryFilter\QueryFilter;
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