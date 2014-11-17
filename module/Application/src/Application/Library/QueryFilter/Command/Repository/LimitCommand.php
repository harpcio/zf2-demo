<?php

namespace Application\Library\QueryFilter\Command\Repository;

use Application\Library\QueryFilter\Criteria;
use Doctrine\ORM\QueryBuilder;

class LimitCommand extends AbstractCommand implements CommandInterface
{
    public static $commandName = Criteria::TYPE_SPECIAL_LIMIT;

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

        $qb->setMaxResults($criteria->getValue());

        return true;
    }
}