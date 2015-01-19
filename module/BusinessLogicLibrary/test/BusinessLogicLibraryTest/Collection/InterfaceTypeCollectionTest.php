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

class InterfaceTypeCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Provider\MyClassInterfaceCollection
     */
    private $testedObject;

    public function setUp()
    {
        $this->testedObject = new Provider\MyClassInterfaceCollection(
            [
                new Provider\HisClass('a', 'b'),
                new Provider\HisClass(1, 2)
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
        /** @var Provider\HisClass $result */
        $result = $this->testedObject->offsetGet(0);

        $this->assertInstanceOf(Provider\HisClass::class, $result);
        $this->assertSame(0, $result->getA());
        $this->assertSame(0, $result->getB());
    }

    public function testOffsetSet()
    {
        $this->testedObject->offsetSet(2, new Provider\HisClass(2, 5));

        /** @var Provider\MyClass $result */
        $result = $this->testedObject->offsetGet(2);

        $this->assertInstanceOf(Provider\HisClass::class, $result);
        $this->assertSame(2, $result->getA());
        $this->assertSame(5, $result->getB());
    }

    public function testOffsetSet_WithInvalidObject()
    {
        $this->setExpectedException(
            'UnexpectedValueException',
            'Illegal object, expected instance of: BusinessLogicLibraryTest\\Collection\\Provider\\MyClassInterface'
        );
        $this->testedObject->offsetSet(2, new Provider\NotMyClass(true, new \DateTime()));
    }

    public function testGetIterator()
    {
        $result = $this->testedObject->getIterator();

        $this->assertInstanceOf(\ArrayIterator::class, $result);
    }

    public function testInitializeInterfaceTypeCollectionWithoutType()
    {
        $this->setExpectedException('LogicException', 'Variable $interfaceOrObjectName not defined');

        new Provider\InvalidMyClassInterfaceCollection(
            [
                new Provider\HisClass('a', 'b'),
                new Provider\HisClass(1, 2)
            ]
        );
    }
}