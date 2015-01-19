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

class InArrayCommand implements CommandInterface
{
    public function execute($key, $value, QueryFilter $queryFilter)
    {
        $value = explode(',', $value);
        $value = array_map('trim', $value);
        $value = array_filter(
            $value,
            function ($el) {
                return $el !== '';
            }
        );

        $queryFilter->addCriteria(new Criteria(Criteria::TYPE_CONDITION_IN_ARRAY, $key, $value));

        return true;
    }
}