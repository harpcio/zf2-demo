<?php

namespace Application\Library\QueryFilter\Command\Criteria;

use Application\Library\QueryFilter\Command\CommandInterface;
use Application\Library\QueryFilter\Condition;
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

        $queryFilter->addCriteria($key, new Condition(Condition::TYPE_IN_ARRAY, $value));

        return true;
    }
}