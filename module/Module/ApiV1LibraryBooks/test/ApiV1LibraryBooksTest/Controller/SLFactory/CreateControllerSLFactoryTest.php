<?php

namespace Module\ApiV1LibraryBooksTest\Controller\SLFactory;

use Module\ApiV1LibraryBooks\Controller\CreateController;
use Module\ApiV1LibraryBooks\Controller\SLFactory\CreateControllerSLFactory;
use Test\Bootstrap;
use Zend\Mvc\Controller\ControllerManager;

class CreateControllerSLFactoryTest extends \PHPUnit_Framework_TestCase
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