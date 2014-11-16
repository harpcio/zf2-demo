<?php

namespace Application\Library\Repository\Command;

use Application\Library\QueryFilter\Condition;
use Doctrine\ORM\QueryBuilder;

class MaxCommand implements CommandInterface
{
    public static $commandName = Condition::TYPE_MAX;

    /**
     * @param QueryBuilder $qb
     * @param Condition    $condition
     * @param string       $columnName
     * @param int          $i
     *
     * @return true
     */
    public function execute(QueryBuilder $qb, Condition $condition, $columnName, $i)
    {
        if ($condition->getType() !== self::$commandName) {
            return false;
        }

        $param = ':max' . $i;
        $qb->andWhere($qb->expr()->lte($columnName, $param))
            ->setParameter($param, $condition->getData());

        return true;
    }
}