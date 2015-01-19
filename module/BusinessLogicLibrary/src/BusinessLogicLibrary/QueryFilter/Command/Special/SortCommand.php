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

namespace BusinessLogicLibrary\QueryFilter\Command\Special;

use BusinessLogicLibrary\QueryFilter\Criteria;
use BusinessLogicLibrary\QueryFilter\QueryFilter;

class SortCommand extends AbstractCommand
{
    /**
     * @var string
     */
    protected $commandName = '$sort';

    public function execute(array $query, QueryFilter $queryFilter)
    {
        if (!isset($query[$this->commandName])) {
            return false;
        }

        $value = $query[$this->commandName];

        $this->setOrderBy($queryFilter, $value);

        return true;
    }

    private function setOrderBy(QueryFilter $queryFilter, $value)
    {
        $value = explode(',', $value);
        $value = array_map('trim', $value);
        $value = array_filter(
            $value,
            function ($el) {
                return $el !== '';
            }
        );

        foreach ($value as $sortColumn) {
            $order = 'asc';
            if ($sortColumn[0] === '-') {
                $sortColumn = substr($sortColumn, 1);
                $order = 'desc';
            }

            $queryFilter->addCriteria(
                new Criteria(
                    Criteria::TYPE_SPECIAL_SORT,
                    $sortColumn,
                    $order
                )
            );
        }
    }
}