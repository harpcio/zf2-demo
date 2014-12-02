<?php

namespace AclTest\Service\Listener;

use Acl\Service\AclService;
use Acl\Service\Listener\CheckAccessListener;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Mvc\MvcEvent;

class CheckAccessListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CheckAccessListener
     */
    private $testedObject;

    /**
     * @var MockObject
     */
    private $checkAclServiceMock;

    public function setUp()
    {
        $this->checkAclServiceMock = $this->getMockBuilder(AclService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->testedObject = new CheckAccessListener($this->checkAclServiceMock);
    }

    public function testInvoke()
    {
        $event = new MvcEvent();

        $this->checkAclServiceMock->expects($this->once())
            ->method('checkAccess')
            ->with($event);

        $this->testedObject->__invoke($event);
    }
}