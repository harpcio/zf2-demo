<?php

namespace Application\Library\QueryFilter\Command\Repository;

use Application\Library\QueryFilter\Criteria;
use Doctrine\ORM\QueryBuilder;

interface CommandInterface
{
    /**
     * @param QueryBuilder $qb
     * @param Criteria     $criteria
     * @param array        $entityFieldNames
     * @param string       $alias
     * @param int          $i
     *
     * @return bool
     */
    public function execute(QueryBuilder $qb, Criteria $criteria, array $entityFieldNames, $alias, $i);
}