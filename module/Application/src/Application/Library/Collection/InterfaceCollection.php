<?php

namespace Application\Library\Collection;

abstract class InterfaceCollection implements \ArrayAccess, \IteratorAggregate
{
    protected $interface = null;

    private $elements = array();

    public function __construct(array $elements = [])
    {
        if (!$this->interface) {
            throw new \LogicException('Interface not defined');
        }

        foreach ($elements as $element) {
            if ($this->interface && !($element instanceof $this->interface)) {
                throw new \UnexpectedValueException(
                    sprintf('Illegal object, expected instance of: %s', $this->interface)
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
        if ($this->interface && !($value instanceof $this->interface)) {
            throw new \UnexpectedValueException(
                sprintf('Illegal object, expected instance of: %s', $this->interface)
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