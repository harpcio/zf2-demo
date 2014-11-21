<?php

namespace AuthTest\Service\Adapter;

use Auth\Service\Adapter\DbAdapter;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NonUniqueResultException;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use User\Repository\UserRepositoryInterface;
use UserTest\Entity\Provider\UserEntityProvider;
use Zend\Authentication\Result;
use Zend\Crypt\Password\PasswordInterface;

class DbAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DbAdapter
     */
    private $testedObject;

    /**
     * @var MockObject
     */
    private $userRepositoryMock;

    /**
     * @var MockObject
     */
    private $cryptMock;

    public function setUp()
    {
        $this->userRepositoryMock = $this->getMockBuilder(UserRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->cryptMock = $this->getMockBuilder(PasswordInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->testedObject = new DbAdapter(
            $this->userRepositoryMock, $this->cryptMock
        );
    }

    public function testAuthenticate_WithSuccess()
    {
        $userEntity = UserEntityProvider::createEntityWithRandomData();

        $this->testedObject->setIdentity($userEntity->getLogin())
            ->setCredential($userEntity->getPassword());

        $this->userRepositoryMock->expects($this->once())
            ->method('findOneBy')
            ->with(['login' => $userEntity->getLogin()])
            ->will($this->returnValue($userEntity));

        $this->cryptMock->expects($this->once())
            ->method('verify')
            ->with($userEntity->getPassword(), $userEntity->getPassword())
            ->will($this->returnValue(true));

        $result = $this->testedObject->authenticate();

        $this->assertInstanceOf(Result::class, $result);
        $this->assertTrue($result->isValid());
        $this->assertSame($userEntity->getId(), $result->getIdentity());
    }

    public function testAuthenticate_WithEntityNotFoundException()
    {
        $userEntity = UserEntityProvider::createEntityWithRandomData();

        $this->testedObject->setIdentity($userEntity->getLogin())
            ->setCredential($userEntity->getPassword());

        $this->userRepositoryMock->expects($this->once())
            ->method('findOneBy')
            ->with(['login' => $userEntity->getLogin()])
            ->will($this->throwException(new EntityNotFoundException('Not found')));

        $result = $this->testedObject->authenticate();

        $this->assertInstanceOf(Result::class, $result);
        $this->assertFalse($result->isValid());
        $this->assertSame(null, $result->getIdentity());
    }

    public function testAuthenticate_WithNonUniqueResultException()
    {
        $userEntity = UserEntityProvider::createEntityWithRandomData();

        $this->testedObject->setIdentity($userEntity->getLogin())
            ->setCredential($userEntity->getPassword());

        $this->userRepositoryMock->expects($this->once())
            ->method('findOneBy')
            ->with(['login' => $userEntity->getLogin()])
            ->will($this->throwException(new NonUniqueResultException('Found 5 entities with the same login')));

        $result = $this->testedObject->authenticate();

        $this->assertInstanceOf(Result::class, $result);
        $this->assertFalse($result->isValid());
        $this->assertSame(null, $result->getIdentity());
    }

    public function testAuthenticate_WhenVerifyFailed()
    {
        $userEntity = UserEntityProvider::createEntityWithRandomData();

        $differentPassword = uniqid('password');

        $this->testedObject->setIdentity($userEntity->getLogin())
            ->setCredential($differentPassword);

        $this->userRepositoryMock->expects($this->once())
            ->method('findOneBy')
            ->with(['login' => $userEntity->getLogin()])
            ->will($this->returnValue($userEntity));

        $this->cryptMock->expects($this->once())
            ->method('verify')
            ->with($differentPassword, $userEntity->getPassword())
            ->will($this->returnValue(false));

        $result = $this->testedObject->authenticate();

        $this->assertInstanceOf(Result::class, $result);
        $this->assertFalse($result->isValid());
        $this->assertSame(null, $result->getIdentity());
    }
}