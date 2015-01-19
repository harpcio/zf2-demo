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

namespace ApplicationDataAccessDoctrineORMLibrary\QueryFilter\Command\Repository\SLFactory;

use BusinessLogicLibrary\QueryFilter\Command\Repository\CommandCollection;
use ApplicationDataAccessDoctrineORMLibrary\QueryFilter\Command\Repository;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CommandCollectionSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return CommandCollection
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new CommandCollection(
            [
                Repository\BetweenCommand::$commandName => new Repository\BetweenCommand(),
                Repository\StartsWithCommand::$commandName => new Repository\StartsWithCommand(),
                Repository\EndsWithCommand::$commandName => new Repository\EndsWithCommand(),
                Repository\MinCommand::$commandName => new Repository\MinCommand(),
                Repository\MaxCommand::$commandName => new Repository\MaxCommand(),
                Repository\EqualCommand::$commandName => new Repository\EqualCommand(),
                Repository\InArrayCommand::$commandName => new Repository\InArrayCommand(),
                Repository\FieldsCommand::$commandName => new Repository\FieldsCommand(),
                Repository\SortCommand::$commandName => new Repository\SortCommand(),
                Repository\LimitCommand::$commandName => new Repository\LimitCommand(),
                Repository\OffsetCommand::$commandName => new Repository\OffsetCommand(),
            ]
        );
    }
}
