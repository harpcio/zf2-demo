<?php

namespace AuthTest\Service;

use Auth\Service\Adapter\DbAdapter;
use Auth\Form\LoginFormInputFilter;
use Auth\Service\LoginService;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Authentication\Result;

class LoginServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LoginService
     */
    private $testedObject;

    /**
     * @var MockObject
     */
    private $authenticationServiceMock;

    /**
     * @var MockObject
     */
    private $adapterMock;

    public function setUp()
    {
        $this->authenticationServiceMock = $this->getMockBuilder(AuthenticationServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->adapterMock = $this->getMockBuilder(DbAdapter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->testedObject = new LoginService($this->authenticationServiceMock, $this->adapterMock);
    }

    public function testLoginWithValidFilter()
    {
        $userId = mt_rand(1, 100);

        $data = [
            'login' => uniqid('admin'),
            'password' => uniqid('password')
        ];

        $filter = new LoginFormInputFilter();
        $filter->setData($data);

        $this->adapterMock->expects($this->once())
            ->method('setIdentity')
            ->with($filter->getValue('login'));

        $this->adapterMock->expects($this->once())
            ->method('setCredential')
            ->with($filter->getValue('password'));

        $authResult = new Result(Result::SUCCESS, $userId);

        $this->authenticationServiceMock->expects($this->once())
            ->method('authenticate')
            ->with($this->adapterMock)
            ->will($this->returnValue($authResult));

        $result = $this->testedObject->login($filter);

        $this->assertTrue($result);
    }

    public function testLoginWithInValidFilter()
    {
        $data = [
            'login' => 'a',
            'password' => 'p'
        ];

        $filter = new LoginFormInputFilter();
        $filter->setData($data);

        $this->setExpectedException('LogicException', 'Form is not valid');

        $this->testedObject->login($filter);
    }
}