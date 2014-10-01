<?php

namespace LibraryTest\Controller\Book\Factory;

use Library\Controller\Book\UpdateController;
use Library\Controller\Book\Factory\UpdateControllerFactory;
use Test\Bootstrap;
use Zend\Mvc\Controller\ControllerManager;

class UpdateControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UpdateControllerFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new UpdateControllerFactory();
    }

    public function testCreateService()
    {
        $controllerManager = new ControllerManager();
        $controllerManager->setServiceLocator(Bootstrap::getServiceManager());

        $result = $this->testedObj->createService($controllerManager);

        $this->assertInstanceOf(UpdateController::class, $result);
    }
}