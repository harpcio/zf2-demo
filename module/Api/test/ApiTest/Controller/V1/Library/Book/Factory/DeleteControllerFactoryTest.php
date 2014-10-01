<?php

namespace ApiTest\Controller\V1\Library\Book\Factory;

use Api\Controller\V1\Library\Book\DeleteController;
use Api\Controller\V1\Library\Book\Factory\DeleteControllerFactory;
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