<?php

namespace Application\Library\QueryFilter\Command\Criteria;

use Application\Library\QueryFilter\Command\CommandInterface;
use Application\Library\QueryFilter\Condition;
use Application\Library\QueryFilter\QueryFilter;

class StartsEndsWithCommand implements CommandInterface
{
    public static $commandRegex = '/^\$(startswith|endswith)\(\"?([^\)\"]*)\"?\)/';

    public function execute($key, $value, QueryFilter $queryFilter)
    {
        if (!preg_match(static::$commandRegex, $value, $matches)) {
            return false;
        }

        $command = trim($matches[1]);
        $data = trim($matches[2]);

        $queryFilter->addCriteria($key, new Condition($command, $data));

        return true;
    }
}