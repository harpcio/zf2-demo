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

class FieldsCommand implements CommandInterface
{
    public static $commandName = Criteria::TYPE_SPECIAL_FIELDS;

    /**
     * @inheritdoc
     */
    public function execute($queryBuilder, Criteria $criteria)
    {
        if ($criteria->getType() !== self::$commandName) {
            return false;
        }

        /** @var QueryBuilder $queryBuilder */
        $aliases = $queryBuilder->getRootAliases();
        $rootAlias = reset($aliases);

        $columns = [];
        $values = (array)$criteria->getKey();
        foreach ($values as $columnName) {
            $columns[] = $rootAlias . '.' . $columnName;
        }

        if (!empty($columns)) {
            $queryBuilder->select($columns);
        }

        return true;
    }
}