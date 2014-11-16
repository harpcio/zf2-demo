<?php

namespace Application\Library\Repository\Command;

use Application\Library\QueryFilter\Condition;
use Doctrine\ORM\QueryBuilder;

interface CommandInterface
{
    /**
     * @param QueryBuilder $qb
     * @param Condition    $condition
     * @param string       $columnName
     * @param int          $i
     *
     * @return true
     */
    public function execute(QueryBuilder $qb, Condition $condition, $columnName, $i);
}