<?php

namespace Library\QueryFilter\Command\Repository;

use Library\QueryFilter\Criteria;
use Doctrine\ORM\QueryBuilder;

class OffsetCommand extends AbstractCommand implements CommandInterface
{
    public static $commandName = Criteria::TYPE_SPECIAL_OFFSET;

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

        $qb->setFirstResult($criteria->getValue());

        return true;
    }
}