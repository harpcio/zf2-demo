<?php

namespace Application\Library\QueryFilter;

use Application\Library\QueryFilter\Command\CommandInterface;

class QueryFilter
{
    /**
     * @var array
     */
    private $specialCommands = [];

    /**
     * @var array
     */
    private $criteriaCommands = [];

    /**
     * @var array
     */
    private $expectedFields = [];

    /**
     * @var array
     */
    private $criteria = [];

    /**
     * @var array
     */
    private $orderBy = [];

    /**
     * @var int|null
     */
    private $limit = null;

    /**
     * @var int|null
     */
    private $offset = null;

    public function __construct(array $specialCommands, array $criteriaCommands)
    {
        $this->specialCommands = $specialCommands;
        $this->criteriaCommands = $criteriaCommands;
    }

    public function setExpectedFields(array $expectedFields)
    {
        $this->expectedFields = $expectedFields;
    }

    /**
     * @param string $expectedField
     *
     * @return bool
     */
    public function expectedFieldExists($expectedField)
    {
        return in_array($expectedField, $this->expectedFields);
    }

    /**
     * @param string $sort
     * @param string $order
     */
    public function addOrderBy($sort, $order)
    {
        $this->orderBy[$sort] = $order;
    }

    /**
     * @return array
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = (int)$limit;
    }

    /**
     * @return int|null
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $offset
     */
    public function setOffset($offset)
    {
        $this->offset = (int)$offset;
    }

    /**
     * @return int|null
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param string    $key
     * @param Condition $condition
     */
    public function addCriteria($key, Condition $condition)
    {
        $this->criteria[$key] = $condition;
    }

    /**
     * @return array
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    public function setQueryParameters(array $query)
    {
        foreach ($query as $key => $value) {
            $value = trim(urldecode($value));

            if (empty($value)) {
                continue;
            }

            /** @var CommandInterface $command */
            foreach ($this->specialCommands as $command) {
                if ($command->execute($key, $value, $this)) {
                    continue 2;
                }
            }

            if (!$this->expectedFieldExists($key)) {
                throw new Exception\UnrecognizedFieldException(
                    sprintf('Unrecognized field "%s"', $key)
                );
            }

            /** @var CommandInterface $command */
            foreach ($this->criteriaCommands as $command) {
                if ($command->execute($key, $value, $this)) {
                    continue 2;
                }
            }
        }
    }
}