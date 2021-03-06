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

namespace BusinessLogicLibrary\QueryFilter\Command\Repository;

use BusinessLogicLibrary\Collection\AbstractInterfaceTypeCollection;

class CommandCollection extends AbstractInterfaceTypeCollection
{
    protected $interfaceOrObjectName = CommandInterface::class;
}