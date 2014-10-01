<?php

namespace ApiTest\Controller\V1\Library\Book\Factory;

use Api\Controller\V1\Library\Book\GetListController;
use Api\Controller\V1\Library\Book\Factory\GetListControllerFactory;
use Test\Bootstrap;
use Zend\Mvc\Controller\ControllerManager;

class GetListControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GetListControllerFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new GetListControllerFactory();
    }

    public function testCreateService()
    {
        $controllerManager = new ControllerManager();
        $controllerManager->setServiceLocator(Bootstrap::getServiceManager());

        $result = $this->testedObj->createService($controllerManager);

        $this->assertInstanceOf(GetListController::class, $result);
    }
}