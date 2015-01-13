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

namespace BusinessLogicDomainUsersTest\Entity;

use BusinessLogicDomainUsers\Entity\UserEntity;
use BusinessLogicDomainUsers\Entity\UserEntityInterface;

class UserEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UserEntity
     */
    private $testedObject;

    public function setUp()
    {
        $this->testedObject = new UserEntity();
    }

    public function testInstance()
    {
        $this->assertNull($this->testedObject->getId());
    }

    public function testSetAndGetName()
    {
        $value = uniqid('name');

        $this->testedObject->setName($value);
        $result = $this->testedObject->getName();

        $this->assertSame($value, $result);
    }

    public function testSetAndGetLogin()
    {
        $value = uniqid('login');

        $this->testedObject->setLogin($value);
        $result = $this->testedObject->getLogin();

        $this->assertSame($value, $result);
    }

    public function testSetAndGetEmail()
    {
        $value = uniqid('email');

        $this->testedObject->setEmail($value);
        $result = $this->testedObject->getEmail();

        $this->assertSame($value, $result);
    }

    public function testSetAndGetPassword()
    {
        $value = uniqid('password');

        $this->testedObject->setPassword($value);
        $result = $this->testedObject->getPassword();

        $this->assertSame($value, $result);
    }

    public function testSetAndGetRole()
    {
        $value = UserEntityInterface::ROLE_ADMIN;

        $this->testedObject->setRole($value);
        $result = $this->testedObject->getRole();

        $this->assertSame($value, $result);
    }

    public function testSetRole_WithNotAllowedRole()
    {
        $value = uniqid('role');

        $this->setExpectedException('InvalidArgumentException', sprintf('Role %s not allowed!', $value));
        $this->testedObject->setRole($value);
    }
}