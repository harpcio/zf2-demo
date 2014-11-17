<?php

namespace Application\Library\QueryFilter\Command\Condition;

use Application\Library\QueryFilter\Command\CommandInterface;
use Application\Library\QueryFilter\Criteria;
use Application\Library\QueryFilter\QueryFilter;

class BetweenCommand implements CommandInterface
{
    public static $commandRegex = '/^\$(between)\(([^\,]*),([^\)]*)\)/';

    public function execute($key, $value, QueryFilter $queryFilter)
    {
        if (!preg_match(static::$commandRegex, $value, $matches)) {
            return false;
        }

        $command = trim($matches[1]);
        $start = trim($matches[2]);
        $end = trim($matches[3]);

        if ($start > $end) {
            list($start, $end) = [$end, $start];
        }

        $queryFilter->addCriteria(new Criteria($command, $key, [$start, $end]));

        return true;
    }
}