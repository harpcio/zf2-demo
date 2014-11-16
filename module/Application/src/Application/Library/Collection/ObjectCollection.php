<?php

namespace Application\Library\Collection;

abstract class ObjectCollection implements \ArrayAccess, \IteratorAggregate
{
    protected $type = null;

    private $elements = array();

    public function __construct(array $elements = [])
    {
        if (!$this->type) {
            throw new \LogicException('Type not defined');
        }

        foreach ($elements as $element) {
            if ($this->type && !is_a($element, $this->type)) {
                throw new \UnexpectedValueException(
                    sprintf('Illegal object. Expected: %s, got %s', $this->type, get_class($element))
                );
            }
        }

        $this->elements = $elements;
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
        if ($this->type && !is_a($value, $this->type)) {
            throw new \UnexpectedValueException(
                sprintf('Illegal class name, expected: %s, got %s', $this->type, get_class($value))
            );
        }
        if (is_null($offset)) {
            $this->elements[] = $value;
        } else {
            $this->elements[$offset] = $value;
        }
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->elements);
    }
}