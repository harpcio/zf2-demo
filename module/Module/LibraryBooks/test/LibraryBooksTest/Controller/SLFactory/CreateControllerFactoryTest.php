<?php

namespace Module\LibraryBooksTest\Controller\SLFactory;

use Module\LibraryBooks\Controller\CreateController;
use Module\LibraryBooks\Controller\SLFactory\CreateControllerSLFactory;
use Test\Bootstrap;
use Zend\Mvc\Controller\ControllerManager;

class CreateControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CreateControllerSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new CreateControllerSLFactory();
    }

    public function testCreateService()
    {
        $controllerManager = new ControllerManager();
        $controllerManager->setServiceLocator(Bootstrap::getServiceManager());

        $result = $this->testedObj->createService($controllerManager);

        $this->assertInstanceOf(CreateController::class, $result);
    }
}