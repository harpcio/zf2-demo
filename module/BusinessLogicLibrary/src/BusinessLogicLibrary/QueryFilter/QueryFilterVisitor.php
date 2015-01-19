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

namespace BusinessLogicLibrary\QueryFilter;

use BusinessLogicLibrary\QueryFilter\Command\Repository\CommandCollection;
use BusinessLogicLibrary\QueryFilter\Command\Repository\CommandInterface;

class QueryFilterVisitor implements QueryFilterVisitorInterface
{
    /**
     * @var QueryFilter
     */
    protected $queryFilter;

    /**
     * @var CommandCollection
     */
    protected $commandCollection;

    public function __construct(QueryFilter $queryFilter, CommandCollection $commandCollection)
    {
        $this->queryFilter = $queryFilter;
        $this->commandCollection = $commandCollection;
    }

    /**
     * @param mixed $queryBuilder
     * @param array $entityFieldNames
     * @return mixed
     * @throws Exception\UnsupportedTypeException
     */
    public function visit($queryBuilder, array $entityFieldNames)
    {
        /** @var $criteria Criteria */
        foreach ($this->queryFilter->getCriteria() as $criteria) {
            $this->checkCriteriaKey($criteria->getKey(), $entityFieldNames);

            /** @var CommandInterface $command */
            if (!($command = $this->commandCollection->offsetGet($criteria->getType()))) {
                throw new Exception\UnsupportedTypeException(sprintf(
                    'Tried to filter by field "%s" that is not supported',
                    $criteria->getType()
                ));
            }
            $command->execute($queryBuilder, $criteria);
        }

        return $queryBuilder;
    }

    /**
     * @param mixed $key
     * @param array $entityFieldNames
     * @throws Exception\UnrecognizedFieldException
     */
    private function checkCriteriaKey($key, array $entityFieldNames)
    {
        if (null === $key) {
            return;
        }

        if (is_array($key)) {
            foreach ($key as $columnName) {
                $this->checkColumnNameInEntityFieldNames($columnName, $entityFieldNames);
            }
        } else {
            $this->checkColumnNameInEntityFieldNames($key, $entityFieldNames);
        }
    }

    /**
     * @param string $columnName
     * @param array  $entityFieldNames
     * @throws Exception\UnrecognizedFieldException
     */
    private function checkColumnNameInEntityFieldNames($columnName, array $entityFieldNames)
    {
        if (!in_array($columnName, $entityFieldNames)) {
            throw new Exception\UnrecognizedFieldException(
                sprintf('Tried to filter by field "%s" which does not exist in entity', $columnName)
            );
        }
    }
}