<?php

namespace LibraryTest\Controller\Book\Factory;

use Library\Controller\Book\ReadController;
use Library\Controller\Book\Factory\ReadControllerFactory;
use Test\Bootstrap;
use Zend\Mvc\Controller\ControllerManager;

class ReadControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ReadControllerFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new ReadControllerFactory();
    }

    public function testCreateService()
    {
        $controllerManager = new ControllerManager();
        $controllerManager->setServiceLocator(Bootstrap::getServiceManager());

        $result = $this->testedObj->createService($controllerManager);

        $this->assertInstanceOf(ReadController::class, $result);
    }
}