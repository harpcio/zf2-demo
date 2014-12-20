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

namespace Library\QueryFilter\Command\Repository\SLFactory;

use Library\QueryFilter\Command;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CommandCollectionSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return Command\Repository\CommandCollection
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new Command\Repository\CommandCollection(
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
    }
}
