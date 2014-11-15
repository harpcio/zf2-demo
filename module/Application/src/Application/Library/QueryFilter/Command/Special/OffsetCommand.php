<?php

namespace Application\Library\QueryFilter\Command\Special;

use Application\Library\QueryFilter\Command\CommandInterface;
use Application\Library\QueryFilter\QueryFilter;

class OffsetCommand implements CommandInterface
{
    public static $commandName = '$offset';

    public function execute($key, $value, QueryFilter $queryFilter)
    {
        if ($key !== static::$commandName) {
            return false;
        }

        $queryFilter->setOffset($value);

        return true;
    }
}