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
        if ($this->interfaceOrObjectName && !($value instanceof $this->interfaceOrObjectName)) {
            throw new \UnexpectedValueException(
                sprintf('Illegal object, expected instance of: %s', $this->interfaceOrObjectName)
            );
        }
    }
}