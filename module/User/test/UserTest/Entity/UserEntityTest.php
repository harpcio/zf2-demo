<?php

namespace UserTest\Entity;

use User\Entity\UserEntity;

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
}