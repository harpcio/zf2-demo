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

namespace Library\QueryFilter\Command;

use Library\QueryFilter\QueryFilter;

interface CommandInterface
{
    /**
     * @param string      $key
     * @param mixed       $value
     * @param QueryFilter $queryFilter
     *
     * @return bool
     */
    public function execute($key, $value, QueryFilter $queryFilter);
}