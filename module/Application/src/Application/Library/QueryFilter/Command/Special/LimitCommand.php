<?php

namespace Application\Library\QueryFilter\Command\Special;

use Application\Library\QueryFilter\Command\CommandInterface;
use Application\Library\QueryFilter\QueryFilter;

class LimitCommand implements CommandInterface
{
    public static $commandName = '$limit';

    public function execute($key, $value, QueryFilter $queryFilter)
    {
        if ($key !== static::$commandName) {
            return false;
        }

        $queryFilter->setLimit($value);

        return true;
    }
}