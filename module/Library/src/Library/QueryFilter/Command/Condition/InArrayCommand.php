<?php

namespace Library\QueryFilter\Command\Condition;

use Library\QueryFilter\Command\CommandInterface;
use Library\QueryFilter\Criteria;
use Library\QueryFilter\QueryFilter;

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