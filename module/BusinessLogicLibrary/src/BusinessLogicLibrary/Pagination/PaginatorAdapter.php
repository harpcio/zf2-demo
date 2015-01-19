<?php

namespace BusinessLogicLibrary\Pagination;

use Countable;
use IteratorAggregate;

class PaginatorAdapter implements Countable, IteratorAggregate
{
    /**
     * @var Countable|IteratorAggregate
     */
    private $adapter;

    public function __construct($adapter)
    {
        if (!($adapter instanceof Countable) || !($adapter instanceof IteratorAggregate)) {
            throw new \InvalidArgumentException('Paginator adapter must be instanceof Countable and IteratorAggregate');
        }

        $this->adapter = $adapter;
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->adapter->count();
    }

    /**
     * @return \Traversable
     */
    public function getIterator()
    {
        return $this->adapter->getIterator();
    }
}