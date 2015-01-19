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

use BusinessLogicLibrary\QueryFilter\Command\Condition;
use BusinessLogicLibrary\QueryFilter\Command\Special;

class QueryFilter
{
    /**
     * @var array
     */
    private $specialCommands = [];

    /**
     * @var array
     */
    private $conditionCommands = [];

    /**
     * @var array
     */
    private $criteria = [];

    public function __construct(array $specialCommands, array $conditionCommands)
    {
        $this->specialCommands = $specialCommands;
        $this->conditionCommands = $conditionCommands;
    }

    /**
     * @param Criteria $criteria
     */
    public function addCriteria(Criteria $criteria)
    {
        if (in_array($criteria->getType(), array(Criteria::TYPE_SPECIAL_LIMIT, Criteria::TYPE_SPECIAL_OFFSET))) {
            $this->criteria[$criteria->getType()] = $criteria;
        } else {
            $this->criteria[] = $criteria;
        }
    }

    /**
     * @param string $type
     * @return array|Criteria
     */
    public function getCriteria($type = null)
    {
        if ($type === null) {
            return $this->criteria;
        }

        if (isset($this->criteria[$type])) {
            return $this->criteria[$type];
        }

        return null;
    }

    /**
     * @param array $query
     */
    public function setQueryParameters(array $query)
    {
        $this->checkQueryParametersBySpecialCommands($query);
        $this->checkQueryParametersByConditionCommands($query);
    }

    /**
     * @param array $query
     */
    private function checkQueryParametersBySpecialCommands(array &$query)
    {
        /** @var Special\CommandInterface $command */
        foreach ($this->specialCommands as $command) {
            if ($command->execute($query, $this)) {
                unset($query[$command->getCommandName()]);
            }
        }
    }

    /**
     * @param array  $query
     * @param string $parentKey
     */
    private function checkQueryParametersByConditionCommands(array $query, $parentKey = null)
    {
        foreach ($query as $key => $value) {
            if (is_array($value)) {
                if (null === $parentKey) {
                    $this->checkQueryParametersByConditionCommands($value, $key);
                }
                continue;
            }

            $value = trim(urldecode($value));

            if (empty($value)) {
                continue;
            }

            $this->runConditionCommands($parentKey ?: $key, $value);
        }
    }

    /**
     * @param string $key
     * @param string $value
     */
    private function runConditionCommands($key, $value)
    {
        /** @var Condition\CommandInterface $command */
        foreach ($this->conditionCommands as $command) {
            if ($command->execute($key, $value, $this)) {
                break;
            }
        }
    }
}