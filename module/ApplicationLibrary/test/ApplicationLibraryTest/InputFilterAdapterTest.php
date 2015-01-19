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

namespace ApplicationLibraryTest;

use ApplicationLibrary\InputFilterAdapter;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\InputFilter\InputFilterInterface;

class InputFilterAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InputFilterAdapter
     */
    private $testedObject;

    /**
     * @var MockObject|InputFilterInterface
     */
    private $adapterMock;

    public function setUp()
    {
        $this->adapterMock = $this->getMock(InputFilterInterface::class);

        $this->testedObject = new InputFilterAdapter($this->adapterMock);
    }

    public function testIsValid()
    {
        $this->adapterMock->expects($this->once())
            ->method('isValid');

        $this->testedObject->isValid();
    }

    public function testGetValues()
    {
        $this->adapterMock->expects($this->once())
            ->method('getValues');

        $this->testedObject->getValues();
    }

    public function testGetValue()
    {
        $name = uniqid('name');

        $this->adapterMock->expects($this->once())
            ->method('getValue')
            ->with($name);

        $this->testedObject->getValue($name);
    }
}