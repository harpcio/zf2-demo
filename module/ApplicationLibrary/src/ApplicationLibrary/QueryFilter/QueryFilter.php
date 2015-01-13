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

namespace ApplicationLibrary\QueryFilter;

use ApplicationLibrary\QueryFilter\Command\CommandInterface;

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
        $this->checkQueryParameters($query);
    }

    /**
     * @param array  $query
     * @param string $parentKey
     */
    private function checkQueryParameters(array $query, $parentKey = null)
    {
        foreach ($query as $key => $value) {
            if (is_array($value)) {
                if (null === $parentKey) {
                    $this->checkQueryParameters($value, $key);
                }
                continue;
            }

            $value = trim(urldecode($value));

            if (empty($value)) {
                continue;
            }

            $this->runCommands($parentKey ? : $key, $value);
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