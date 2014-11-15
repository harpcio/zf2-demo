<?php

namespace Application\Library\QueryFilter\Command;

use Application\Library\QueryFilter\QueryFilter;

interface CommandInterface
{
    /**
     * @param string      $key
     * @param mixed       $value
     * @param QueryFilter $queryFilter
     *
     * @return bool
     */
    public function execute($key, $value, QueryFilter $queryFilter);
}