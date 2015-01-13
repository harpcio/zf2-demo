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

namespace ApplicationCoreAuthTest\Service\Storage;

use ApplicationCoreAuth\Service\Storage\DbStorage;
use BusinessLogicDomainUsers\Repository\UsersRepositoryInterface;
use BusinessLogicDomainUsersTest\Entity\Provider\UserEntityProvider;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
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
        $this->userRepositoryMock = $this->getMockBuilder(UsersRepositoryInterface::class)
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