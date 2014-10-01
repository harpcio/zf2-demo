<?php

namespace LibraryTest\Controller\Book\Factory;

use Library\Controller\Book\IndexController;
use Library\Controller\Book\Factory\IndexControllerFactory;
use Test\Bootstrap;
use Zend\Mvc\Controller\ControllerManager;

class IndexControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IndexControllerFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new IndexControllerFactory();
    }

    public function testCreateService()
    {
        $controllerManager = new ControllerManager();
        $controllerManager->setServiceLocator(Bootstrap::getServiceManager());

        $result = $this->testedObj->createService($controllerManager);

        $this->assertInstanceOf(IndexController::class, $result);
    }
}