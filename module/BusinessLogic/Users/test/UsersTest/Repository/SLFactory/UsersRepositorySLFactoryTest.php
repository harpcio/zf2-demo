<?php

namespace BusinessLogic\UsersTest\Repository\SLFactory;

use BusinessLogic\Users\Repository\SLFactory\UsersRepositorySLFactory;
use BusinessLogic\Users\Repository\UsersRepository;
use Test\Bootstrap;

Class ManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UsersRepositorySLFactory
     */
    private $testedObject;

    public function setUp()
    {
        $this->testedObject = new UsersRepositorySLFactory();
    }

    public function testCreate()
    {
        $result = $this->testedObject->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(UsersRepository::class, $result);
    }
}