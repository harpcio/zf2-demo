<?php

namespace Application\Library\QueryFilter\Command\Condition;

use Application\Library\QueryFilter\Command\CommandInterface;
use Application\Library\QueryFilter\Criteria;
use Application\Library\QueryFilter\QueryFilter;

class EqualCommand implements CommandInterface
{
    public static $commandRegex = '/^\"([^\"]*)\"/';

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