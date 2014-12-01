<?php

namespace Library\Collection;

abstract class AbstractObjectTypeCollection extends AbstractTypeCollection
{
    /**
     * @param mixed $value
     *
     * @throws \UnexpectedValueException
     */
    public function checkType($value)
    {
        if ($this->type && !is_a($value, $this->type)) {
            throw new \UnexpectedValueException(
                sprintf('Illegal class name, expected: %s, got %s', $this->type, get_class($value))
            );
        }
    }
}