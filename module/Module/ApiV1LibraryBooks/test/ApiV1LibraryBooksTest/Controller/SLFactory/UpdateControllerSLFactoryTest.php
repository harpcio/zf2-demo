<?php

namespace Module\ApiV1LibraryBooksTest\Controller\SLFactory;

use Module\ApiV1LibraryBooks\Controller\UpdateController;
use Module\ApiV1LibraryBooks\Controller\SLFactory\UpdateControllerSLFactory;
use Test\Bootstrap;
use Zend\Mvc\Controller\ControllerManager;

class UpdateControllerSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UpdateControllerSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new UpdateControllerSLFactory();
    }

    public function testCreateService()
    {
        $controllerManager = new ControllerManager();
        $controllerManager->setServiceLocator(Bootstrap::getServiceManager());

        $result = $this->testedObj->createService($controllerManager);

        $this->assertInstanceOf(UpdateController::class, $result);
    }
}