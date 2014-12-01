<?php

namespace Library\QueryFilter\Command\Repository;

use Library\QueryFilter\Criteria;
use Doctrine\ORM\QueryBuilder;

class BetweenCommand extends AbstractCommand implements CommandInterface
{
    public static $commandName = Criteria::TYPE_CONDITION_BETWEEN;

    /**
     * @param QueryBuilder $qb
     * @param Criteria     $criteria
     * @param array        $entityFieldNames
     * @param string       $alias
     * @param int          $i
     *
     * @return bool
     */
    public function execute(QueryBuilder $qb, Criteria $criteria, array $entityFieldNames, $alias, $i)
    {
        if ($criteria->getType() !== self::$commandName) {
            return false;
        }

        $this->checkColumnNameInEntityFieldNames($criteria->getKey(), $entityFieldNames);
        $preparedColumnName = $this->prepareColumnName($criteria->getKey(), $alias);

        $paramLeft = ':betweenLeft' . $i;
        $paramRight = ':betweenRight' . $i;
        $qb->andWhere($qb->expr()->between($preparedColumnName, $paramLeft, $paramRight))
            ->setParameters(
                [
                    $paramLeft => $criteria->getValue()[0],
                    $paramRight => $criteria->getValue()[1]
                ]
            );

        return true;
    }
}