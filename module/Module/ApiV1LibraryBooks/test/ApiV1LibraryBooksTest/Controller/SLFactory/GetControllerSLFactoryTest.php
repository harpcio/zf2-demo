<?php

namespace Module\ApiV1LibraryBooksTest\Controller\SLFactory;

use Module\ApiV1LibraryBooks\Controller\GetController;
use Module\ApiV1LibraryBooks\Controller\SLFactory\GetControllerSLFactory;
use Test\Bootstrap;
use Zend\Mvc\Controller\ControllerManager;

class GetControllerSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GetControllerSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new GetControllerSLFactory();
    }

    public function testCreateService()
    {
        $controllerManager = new ControllerManager();
        $controllerManager->setServiceLocator(Bootstrap::getServiceManager());

        $result = $this->testedObj->createService($controllerManager);

        $this->assertInstanceOf(GetController::class, $result);
    }
}