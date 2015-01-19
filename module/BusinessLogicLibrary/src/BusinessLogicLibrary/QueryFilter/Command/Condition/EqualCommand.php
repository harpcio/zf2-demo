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

namespace BusinessLogicLibrary\QueryFilter\Command\Condition;

use BusinessLogicLibrary\QueryFilter\Criteria;
use BusinessLogicLibrary\QueryFilter\QueryFilter;

class EqualCommand implements CommandInterface
{
    public static $commandRegex = '/^\"([^\"]*)\"$/';

    public function execute($key, $value, QueryFilter $queryFilter)
    {
        if (!preg_match(static::$commandRegex, $value, $matches)) {
            return false;
        }

        $data = trim($matches[1]);
        $queryFilter->addCriteria(new Criteria(Criteria::TYPE_CONDITION_EQUAL, $key, $data));

        return true;
    }
}