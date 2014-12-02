<?php

namespace AclTest\View\Helper;

use Acl\View\Helper\IsAllowed;
use BusinessLogic\UsersTest\Entity\Provider\UserEntityProvider;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Permissions\Acl\AclInterface;
use Zend\View\Renderer\PhpRenderer;

class IsAllowedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IsAllowed
     */
    private $testedObject;

    /**
     * @var MockObject
     */
    private $viewMock;

    /**
     * @var MockObject
     */
    private $aclMock;

    public function setUp()
    {
        $this->viewMock = $this->getMockBuilder(PhpRenderer::class)
            ->setMethods(['getView', 'viewModel', 'identity', 'getRoot', 'getVariable'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->testedObject = new IsAllowed();
        $this->testedObject->setView($this->viewMock);

        $this->viewMock->expects($this->once())
            ->method('viewModel')
            ->will($this->returnSelf());

        $this->viewMock->expects($this->once())
            ->method('getRoot')
            ->will($this->returnSelf());

        $this->aclMock = $this->getMock(AclInterface::class);

        $this->viewMock->expects($this->once())
            ->method('getVariable')
            ->with('acl')
            ->will($this->returnValue($this->aclMock));
    }

    public function testInvoke_WhenUserIsGuest()
    {
        $resource = 'ModuleA\\Sub';
        $privilege = 'ControllerA:ActionB';

        $this->viewMock->expects($this->once())
            ->method('identity')
            ->will($this->returnValue(null));

        $result = $this->testedObject->__invoke($resource, $privilege);

        $this->assertFalse($result);
    }

    public function testInvoke_WhenUserIsLogged()
    {
        $userEntity = UserEntityProvider::createEntityWithRandomData();

        $resource = 'ModuleA\\Sub';
        $privilege = 'ControllerA:ActionB';

        $this->viewMock->expects($this->once())
            ->method('identity')
            ->will($this->returnValue($userEntity));

        $this->aclMock->expects($this->once())
            ->method('isAllowed')
            ->with($userEntity->getRole(), strtolower($resource), strtolower($privilege))
            ->will($this->returnValue(true));

        $result = $this->testedObject->__invoke($resource, $privilege);

        $this->assertTrue($result);
    }
}