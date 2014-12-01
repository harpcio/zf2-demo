<?php

namespace Library\QueryFilter\Command\Condition;

use Library\QueryFilter\Command\CommandInterface;
use Library\QueryFilter\Criteria;
use Library\QueryFilter\QueryFilter;

class MinMaxCommand implements CommandInterface
{
    public static $commandRegex = '/^\$(min|max)\(([^\)]*)\)/';

    public function execute($key, $value, QueryFilter $queryFilter)
    {
        if (!preg_match(static::$commandRegex, $value, $matches)) {
            return false;
        }

        $command = trim($matches[1]);
        $data = trim($matches[2]);

        $queryFilter->addCriteria(new Criteria($command, $key, $data));

        return true;
    }
}