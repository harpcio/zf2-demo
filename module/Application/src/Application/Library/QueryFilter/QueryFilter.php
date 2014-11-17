<?php

namespace Application\Library\QueryFilter;

use Application\Library\QueryFilter\Command\CommandInterface;

class QueryFilter
{
    /**
     * @var array
     */
    private $commands = [];

    /**
     * @var array
     */
    private $criteria = [];

    public function __construct(array $commands)
    {
        $this->commands = $commands;
    }

    /**
     * @param Criteria $condition
     */
    public function addCriteria(Criteria $condition)
    {
        $this->criteria[] = $condition;
    }

    /**
     * @return array
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @param array $query
     */
    public function setQueryParameters(array $query)
    {
        foreach ($query as $key => $value) {
            if (is_array($value)) {
                $this->checkQueryMultipleParameters($key, $value);
                continue;
            }

            $value = trim(urldecode($value));

            if (empty($value)) {
                continue;
            }

            $this->runCommands($key, $value);
        }
    }

    /**
     * @param string $key
     * @param array  $values
     */
    private function checkQueryMultipleParameters($key, array $values)
    {
        foreach ($values as $value) {
            if (is_array($value)) {
                continue;
            }

            $value = trim(urldecode($value));

            if (empty($value)) {
                continue;
            }

            $this->runCommands($key, $value);
        }
    }

    /**
     * @param string $key
     * @param string $value
     */
    private function runCommands($key, $value)
    {
        /** @var CommandInterface $command */
        foreach ($this->commands as $command) {
            if ($command->execute($key, $value, $this)) {
                break;
            }
        }
    }
}