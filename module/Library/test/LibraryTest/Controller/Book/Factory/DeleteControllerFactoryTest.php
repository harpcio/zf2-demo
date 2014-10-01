<?php

namespace LibraryTest\Controller\Book\Factory;

use Library\Controller\Book\DeleteController;
use Library\Controller\Book\Factory\DeleteControllerFactory;
use Test\Bootstrap;
use Zend\Mvc\Controller\ControllerManager;

class DeleteControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DeleteControllerFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new DeleteControllerFactory();
    }

    public function testCreateService()
    {
        $controllerManager = new ControllerManager();
        $controllerManager->setServiceLocator(Bootstrap::getServiceManager());

        $result = $this->testedObj->createService($controllerManager);

        $this->assertInstanceOf(DeleteController::class, $result);
    }
}