<?php

namespace Library\Collection;

abstract class AbstractInterfaceTypeCollection extends AbstractTypeCollection
{
    /**
     * @param mixed $value
     *
     * @throws \UnexpectedValueException
     */
    public function checkType($value)
    {
        if ($this->type && !($value instanceof $this->type)) {
            throw new \UnexpectedValueException(
                sprintf('Illegal object, expected instance of: %s', $this->type)
            );
        }
    }
}