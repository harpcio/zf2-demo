<?php

namespace ApiTest\Controller\V1\Library\Book\Factory;

use Api\Controller\V1\Library\Book\GetController;
use Api\Controller\V1\Library\Book\Factory\GetControllerFactory;
use Test\Bootstrap;
use Zend\Mvc\Controller\ControllerManager;

class GetControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GetControllerFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new GetControllerFactory();
    }

    public function testCreateService()
    {
        $controllerManager = new ControllerManager();
        $controllerManager->setServiceLocator(Bootstrap::getServiceManager());

        $result = $this->testedObj->createService($controllerManager);

        $this->assertInstanceOf(GetController::class, $result);
    }
}