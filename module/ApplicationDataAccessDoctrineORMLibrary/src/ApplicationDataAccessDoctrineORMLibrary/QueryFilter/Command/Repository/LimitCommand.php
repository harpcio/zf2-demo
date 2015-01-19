<?php
/**
 * This file is part of Zf2-demo package
 *
 * @author Rafal Ksiazek <harpcio@gmail.com>
 * @copyright Rafal Ksiazek F.H.U. Studioars
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApplicationDataAccessDoctrineORMLibrary\QueryFilter\Command\Repository;

use BusinessLogicLibrary\QueryFilter\Command\Repository\CommandInterface;
use BusinessLogicLibrary\QueryFilter\Criteria;
use Doctrine\ORM\QueryBuilder;

class LimitCommand implements CommandInterface
{
    public static $commandName = Criteria::TYPE_SPECIAL_LIMIT;

    /**
     * @inheritdoc
     */
    public function execute($queryBuilder, Criteria $criteria)
    {
        if ($criteria->getType() !== self::$commandName) {
            return false;
        }

        /** @var QueryBuilder $queryBuilder */
        $queryBuilder->setMaxResults($criteria->getValue());

        return true;
    }
}