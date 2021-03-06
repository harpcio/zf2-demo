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

namespace ApplicationLibraryTest\Logger;

use ApplicationLibrary\Logger\Factory\ComponentsFactory;
use ApplicationLibrary\Logger\Manager;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Log\Filter\Priority;
use Zend\Log\Logger;
use Zend\Log\LoggerInterface;
use Zend\Log\Writer\Stream;

Class ManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Manager
     */
    private $testedObject;

    /**
     * @var MockObject
     */
    private $componentsFactoryMock;

    /**
     * @var MockObject
     */
    private $loggerMock;

    /**
     * @var MockObject
     */
    private $streamMock;

    /**
     * @var MockObject
     */
    private $priorityMock;

    public function setUp()
    {
        $this->componentsFactoryMock = $this->getMock(ComponentsFactory::class);

        $this->testedObject = new Manager($this->componentsFactoryMock);

        $this->loggerMock = $this->getMock(Logger::class);

        $this->streamMock = $this->getMockBuilder(Stream::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priorityMock = $this->getMockBuilder(Priority::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testCreateErrorInfoLog()
    {
        $this->componentsFactoryMock->expects($this->once())
            ->method('createLogger')
            ->willReturn($this->loggerMock);

        $this->componentsFactoryMock->expects($this->exactly(2))
            ->method('createStreamWriter')
            ->willReturn($this->streamMock);

        $this->componentsFactoryMock->expects($this->exactly(2))
            ->method('createPriority')
            ->willReturn($this->priorityMock);

        $this->streamMock->expects($this->any())
            ->method('addFilter')
            ->with($this->priorityMock);

        $this->loggerMock->expects($this->exactly(2))
            ->method('addWriter')
            ->with($this->streamMock);

        $result = $this->testedObject->createErrorInfoLog();

        $this->assertInstanceOf(LoggerInterface::class, $result);
    }

    public function testCreateLog()
    {
        $this->componentsFactoryMock->expects($this->once())
            ->method('createLogger')
            ->will($this->returnValue($this->loggerMock));

        $this->componentsFactoryMock->expects($this->once())
            ->method('createStreamWriter')
            ->willReturn($this->streamMock);

        $this->componentsFactoryMock->expects($this->never())
            ->method('createPriority')
            ->willReturn($this->priorityMock);

        $this->streamMock->expects($this->any())
            ->method('addFilter')
            ->with($this->priorityMock);

        $this->loggerMock->expects($this->once())
            ->method('addWriter')
            ->with($this->streamMock);

        $result = $this->testedObject->createLog();

        $this->assertInstanceOf(LoggerInterface::class, $result);
    }

    public function testCreateLogWithAnotherGoodPathAndWithAnotherSeparator()
    {
        $path = ROOT_PATH . '/data';
        $separator = '###';
        $rightFileNamePath = ROOT_PATH . '/data/' . date('Ymd') . sprintf('.%s.log', 'test');

        $this->componentsFactoryMock->expects($this->once())
            ->method('createLogger')
            ->will($this->returnValue($this->loggerMock));

        $this->componentsFactoryMock->expects($this->once())
            ->method('createStreamWriter')
            ->with($rightFileNamePath, null, $separator)
            ->willReturn($this->streamMock);

        $this->componentsFactoryMock->expects($this->never())
            ->method('createPriority')
            ->willReturn($this->priorityMock);

        $this->streamMock->expects($this->any())
            ->method('addFilter')
            ->with($this->priorityMock);

        $this->loggerMock->expects($this->once())
            ->method('addWriter')
            ->with($this->streamMock);

        $result = $this->testedObject->createLog('test', $path, $separator);

        $this->assertInstanceOf(LoggerInterface::class, $result);
    }
}