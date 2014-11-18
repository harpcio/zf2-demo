<?php

namespace Application\Library\QueryFilter\Command\Special;

use Application\Library\QueryFilter\Command\CommandInterface;
use Application\Library\QueryFilter\Criteria;
use Application\Library\QueryFilter\QueryFilter;

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