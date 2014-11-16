<?php

namespace Application\Library\Repository\Command;

use Application\Library\QueryFilter\Condition;
use Doctrine\ORM\QueryBuilder;

class BetweenCommand implements CommandInterface
{
    public static $commandName = Condition::TYPE_BETWEEN;

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

        $paramLeft = ':betweenLeft' . $i;
        $paramRight = ':betweenRight' . $i;
        $qb->andWhere($qb->expr()->between($columnName, $paramLeft, $paramRight))
            ->setParameters(
                [
                    $paramLeft => $condition->getData()[0],
                    $paramRight => $condition->getData()[1]
                ]
            );

        return true;
    }
}