<?php

namespace LibraryTest\Controller\Book\Factory;

use Library\Controller\Book\CreateController;
use Library\Controller\Book\Factory\CreateControllerFactory;
use Test\Bootstrap;
use Zend\Mvc\Controller\ControllerManager;

class CreateControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CreateControllerFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new CreateControllerFactory();
    }

    public function testCreateService()
    {
        $controllerManager = new ControllerManager();
        $controllerManager->setServiceLocator(Bootstrap::getServiceManager());

        $result = $this->testedObj->createService($controllerManager);

        $this->assertInstanceOf(CreateController::class, $result);
    }
}