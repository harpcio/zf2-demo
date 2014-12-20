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