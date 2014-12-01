<?php

namespace Library\Collection;

abstract class AbstractTypeCollection implements \ArrayAccess, \IteratorAggregate
{
    protected $type = null;

    private $elements = array();

    public function __construct(array $elements = [])
    {
        if (!$this->type) {
            throw new \LogicException('Type not defined');
        }

        foreach ($elements as $element) {
            $this->offsetSet(null, $element);
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->elements[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->elements[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->elements[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->checkType($value);

        if (is_null($offset)) {
            $this->elements[] = $value;
        } else {
            $this->elements[$offset] = $value;
        }
    }

    /**
     * @param mixed $value
     *
     * @throws \UnexpectedValueException
     */
    abstract public function checkType($value);

    public function getIterator()
    {
        return new \ArrayIterator($this->elements);
    }
}