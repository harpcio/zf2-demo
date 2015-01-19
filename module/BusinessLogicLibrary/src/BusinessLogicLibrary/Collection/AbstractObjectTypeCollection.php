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

namespace BusinessLogicLibrary\Collection;

abstract class AbstractObjectTypeCollection extends AbstractTypeCollection
{
    /**
     * @param mixed $value
     *
     * @throws \UnexpectedValueException
     */
    public function checkType($value)
    {
        if ($this->interfaceOrObjectName && !is_a($value, $this->interfaceOrObjectName)) {
            throw new \UnexpectedValueException(
                sprintf('Illegal class name, expected: %s, got %s', $this->interfaceOrObjectName, get_class($value))
            );
        }
    }
}