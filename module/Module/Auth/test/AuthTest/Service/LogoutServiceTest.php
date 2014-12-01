<?php

namespace Module\AuthTest\Service;

use Module\Auth\Service\LogoutService;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Authentication\AuthenticationServiceInterface;

class LogoutServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LogoutService
     */
    private $testedObject;

    /**
     * @var MockObject
     */
    private $authenticationServiceMock;

    public function setUp()
    {
        $this->authenticationServiceMock = $this->getMockBuilder(AuthenticationServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->testedObject = new LogoutService($this->authenticationServiceMock);
    }

    public function testLogout()
    {
        $this->authenticationServiceMock->expects($this->once())
            ->method('clearIdentity');

        $this->testedObject->logout();
    }
}