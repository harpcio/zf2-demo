<?php

namespace Library\QueryFilter\Command\Special;

use Library\QueryFilter\Command\CommandInterface;
use Library\QueryFilter\Criteria;
use Library\QueryFilter\QueryFilter;
use Library\QueryFilter\Exception;

class SortCommand implements CommandInterface
{
    public static $commandName = '$sort';

    public function execute($key, $value, QueryFilter $queryFilter)
    {
        if ($key !== static::$commandName) {
            return false;
        }

        $this->setOrderBy($queryFilter, $value);

        return true;
    }

    /**
     * @param QueryFilter $queryFilter
     * @param string      $value
     *
     * @throws Exception\UnrecognizedFieldException
     */
    private function setOrderBy(QueryFilter $queryFilter, $value)
    {
        $value = explode(',', $value);
        $value = array_map('trim', $value);

        foreach ($value as $sortColumn) {
            $order = 'asc';
            if ($sortColumn[0] === '-') {
                $sortColumn = substr($sortColumn, 1);
                $order = 'desc';
            }

            $queryFilter->addCriteria(new Criteria(Criteria::TYPE_SPECIAL_SORT, $sortColumn, $order));
        }
    }
}