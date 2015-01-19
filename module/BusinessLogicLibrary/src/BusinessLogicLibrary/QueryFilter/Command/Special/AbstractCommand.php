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

namespace BusinessLogicLibrary\QueryFilter\Command\Special;

use BusinessLogicLibrary\QueryFilter\QueryFilter;

abstract class AbstractCommand implements CommandInterface
{
    /**
     * @var string
     */
    protected $commandName;

    /**
     * @return string
     */
    public function getCommandName()
    {
        return $this->commandName;
    }

    /**
     * @inheritdoc
     */
    abstract public function execute(array $query, QueryFilter $queryFilter);
}