<?php

namespace Library\QueryFilter\Command\Special;

use Library\QueryFilter\Command\CommandInterface;
use Library\QueryFilter\Criteria;
use Library\QueryFilter\QueryFilter;

class OffsetCommand implements CommandInterface
{
    public static $commandName = '$offset';

    public function execute($key, $value, QueryFilter $queryFilter)
    {
        if ($key !== static::$commandName) {
            return false;
        }

        $queryFilter->addCriteria(new Criteria(Criteria::TYPE_SPECIAL_OFFSET, null, (int)$value));

        return true;
    }
}