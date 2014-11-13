<?php

namespace Application\Library\QueryFilter;

class QueryFilter
{
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

    public function setQuery(array $query)
    {
        foreach ($query as $key => $values) {
            $valuesParts = explode(',', $values);

            $valuesParts = array_map('urldecode', $valuesParts);
            $valuesParts = array_map('trim', $valuesParts);

            $this->add($key, $valuesParts);
        }
    }

    /**
     * @param string    $key
     * @param int|array $values
     */
    private function add($key, $values)
    {
        if (count($values) === 1) {
            $values = reset($values);
        }

        switch ($key) {
            case 'sort':
                $this->setOrderBy($values);
                break;

            case 'limit':
                $this->limit = is_numeric($values) ? (int)$values : null;
                break;

            case 'offset':
                $this->offset = is_numeric($values) ? (int)$values : null;
                break;

            default:
                $this->criteria[$key] = $values;
                break;
        }
    }

    /**
     * @param $values
     */
    private function setOrderBy($values)
    {
        foreach ((array)$values as $elem) {
            $order = 'asc';
            if ($elem[0] === '-') {
                $elem = substr($elem, 1);
                $order = 'desc';
            }

            $this->orderBy[$elem] = $order;
        }
    }

    /**
     * @return array
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @return array
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @return int|null
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return int|null
     */
    public function getOffset()
    {
        return $this->offset;
    }
}