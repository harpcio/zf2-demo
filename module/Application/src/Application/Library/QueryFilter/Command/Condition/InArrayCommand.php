<?php

namespace Application\Library\QueryFilter\Command\Condition;

use Application\Library\QueryFilter\Command\CommandInterface;
use Application\Library\QueryFilter\Criteria;
use Application\Library\QueryFilter\QueryFilter;

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