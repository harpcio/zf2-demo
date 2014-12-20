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

namespace ApplicationTest\Listener\Log;

use Application\Listener\Log\LogExceptionListener;
use Module\Api\Exception\MethodNotAllowedException;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Log\LoggerInterface;
use Zend\Mvc\MvcEvent;

class LogExceptionListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Application\Listener\Log\LogExceptionListener
     */
    private $testedObject;

    /**
     * @var MockObject
     */
    private $loggerMock;

    public function setUp()
    {
        $this->loggerMock = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->testedObject = new LogExceptionListener($this->loggerMock);
    }

    public function testInvoke_WhenExceptionIsNotFromAPI()
    {
        $exception = new \Exception();

        $event = new MvcEvent();
        $event->setParam('exception', $exception);

        $this->loggerMock->expects($this->once())
            ->method('crit')
            ->with($exception);

        $this->testedObject->__invoke($event);
    }

    public function testInvoke_WhenExceptionIsFromAPI()
    {
        $exception = new MethodNotAllowedException();

        $event = new MvcEvent();
        $event->setParam('exception', $exception);

        $this->loggerMock->expects($this->never())
            ->method('crit')
            ->with($exception);

        $this->testedObject->__invoke($event);
    }
}