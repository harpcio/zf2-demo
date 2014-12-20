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

namespace Library\QueryFilter\Command\Repository;

use Library\QueryFilter\Criteria;
use Doctrine\ORM\QueryBuilder;

class FieldsCommand extends AbstractCommand implements CommandInterface
{
    public static $commandName = Criteria::TYPE_SPECIAL_FIELDS;

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

        $columns = [];
        $values = $criteria->getValue();
        foreach ((array)$values as $columnName) {
            $this->checkColumnNameInEntityFieldNames($columnName, $entityFieldNames);
            $columns[] = $alias . '.' . $columnName;
        }

        if (!empty($columns)) {
            $qb->select($columns);
        }

        return true;
    }
}