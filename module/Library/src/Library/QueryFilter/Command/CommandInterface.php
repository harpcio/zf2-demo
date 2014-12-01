<?php

namespace Library\QueryFilter\Command;

use Library\QueryFilter\QueryFilter;

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