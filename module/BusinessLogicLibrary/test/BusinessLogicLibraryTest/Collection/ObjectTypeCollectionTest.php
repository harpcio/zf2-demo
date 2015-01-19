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

namespace BusinessLogicLibraryTest\Collection;

use BusinessLogicLibraryTest\Collection\Provider;

class ObjectTypeCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Provider\MyClassObjectCollection
     */
    private $testedObject;

    public function setUp()
    {
        $this->testedObject = new Provider\MyClassObjectCollection(
            [
                new Provider\MyClass('a', 'b'),
                new Provider\MyClass(1, 2)
            ]
        );
    }

    public function testOffsetExist()
    {
        $result = $this->testedObject->offsetExists(1);

        $this->assertTrue($result);
    }

    public function testOffsetUnset()
    {
        $this->testedObject->offsetUnset(1);

        $result = $this->testedObject->offsetExists(1);

        $this->assertFalse($result);
    }

    public function testOffsetGet()
    {
        /** @var Provider\MyClass $result */
        $result = $this->testedObject->offsetGet(0);

        $this->assertInstanceOf(Provider\MyClass::class, $result);
        $this->assertSame('a', $result->getA());
        $this->assertSame('b', $result->getB());
    }

    public function testOffsetSet()
    {
        $this->testedObject->offsetSet(2, new Provider\MyClass('b', 'y'));

        /** @var Provider\MyClass $result */
        $result = $this->testedObject->offsetGet(2);

        $this->assertInstanceOf(Provider\MyClass::class, $result);
        $this->assertSame('b', $result->getA());
        $this->assertSame('y', $result->getB());
    }

    public function testOffsetSet_WithInvalidObject()
    {
        $this->setExpectedException(
            'UnexpectedValueException',
            'Illegal class name, expected: BusinessLogicLibraryTest\\Collection\\Provider\\MyClass, got BusinessLogicLibraryTest\\Collection\\Provider\\HisClass'
        );
        $this->testedObject->offsetSet(2, new Provider\HisClass(2, 5));
    }

    public function testGetIterator()
    {
        $result = $this->testedObject->getIterator();

        $this->assertInstanceOf(\ArrayIterator::class, $result);
    }

    public function testInitializeObjectTypeCollectionWithoutType()
    {
        $this->setExpectedException('LogicException', 'Variable $interfaceOrObjectName not defined');

        new Provider\InvalidMyClassObjectCollection(
            [
                new Provider\MyClass('a', 'b'),
                new Provider\MyClass(1, 2)
            ]
        );
    }
}