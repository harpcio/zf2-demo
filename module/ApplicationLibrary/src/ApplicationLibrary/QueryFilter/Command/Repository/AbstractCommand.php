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

namespace ApplicationLibrary\QueryFilter\Command\Repository;

use ApplicationLibrary\QueryFilter\Criteria;
use ApplicationLibrary\QueryFilter\Exception\UnrecognizedFieldException;
use Doctrine\ORM\QueryBuilder;

abstract class AbstractCommand implements CommandInterface
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
    abstract public function execute(QueryBuilder $qb, Criteria $criteria, array $entityFieldNames, $alias, $i);

    /**
     * @param string $columnName
     * @param array  $fieldNames
     *
     * @throws UnrecognizedFieldException
     */
    protected function checkColumnNameInEntityFieldNames($columnName, array $fieldNames)
    {
        if (!in_array($columnName, $fieldNames)) {
            throw new UnrecognizedFieldException(
                sprintf('Field unrecognized in entity: %s', $columnName)
            );
        }
    }

    /**
     * @param string $columnName
     * @param string $alias
     *
     * @return string
     */
    protected function prepareColumnName($columnName, $alias)
    {
        return $alias . '.' . $columnName;
    }

}