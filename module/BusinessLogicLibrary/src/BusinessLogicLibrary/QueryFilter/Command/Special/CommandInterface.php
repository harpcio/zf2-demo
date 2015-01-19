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

interface CommandInterface
{
    /**
     * @param array       $query
     * @param QueryFilter $queryFilter
     *
     * @return bool
     */
    public function execute(array $query, QueryFilter $queryFilter);

    /**
     * @return string
     */
    public function getCommandName();
}