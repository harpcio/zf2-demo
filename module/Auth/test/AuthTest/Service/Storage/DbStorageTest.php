<?php

namespace AuthTest\Service\Storage;

use Auth\Service\Storage\DbStorage;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use User\Entity\UserEntity;
use User\Repository\UserRepositoryInterface;
use UserTest\Entity\Provider\UserEntityProvider;
use Zend\Authentication\Storage\Session;

class DbStorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DbStorage
     */
    private $testedObject;

    /**
     * @var MockObject
     */
    private $userRepositoryMock;

    public function setUp()
    {
        $this->userRepositoryMock = $this->getMockBuilder(UserRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->testedObject = new DbStorage($this->userRepositoryMock);
    }

    public function testIsEmpty()
    {
        $result = $this->testedObject->isEmpty();

        $this->assertTrue($result);
    }

    public function testWriteAndReadAndClear()
    {
        $userEntity = UserEntityProvider::createEntityWithRandomData();

        $this->testedObject->write($userEntity->getId());

        $this->userRepositoryMock->expects($this->once())
            ->method('find')
            ->with($userEntity->getId())
            ->will($this->returnValue($userEntity));

        $result = $this->testedObject->read();
        $this->assertSame($userEntity, $result);

        // read again without searching in repository
        $result = $this->testedObject->read();
        $this->assertSame($userEntity, $result);

        $this->testedObject->clear();
        $result = $this->testedObject->read();
        $this->assertSame(null, $result);
    }

    public function testSetGetStorage()
    {
        $identity = mt_rand(1, 100);

        $sessionStorage = new Session();
        $sessionStorage->write($identity);

        $this->testedObject->setStorage($sessionStorage);

        $result = $this->testedObject->getStorage();

        $this->assertInstanceOf(Session::class, $result);
        $this->assertSame($identity, $result->read());
    }

}