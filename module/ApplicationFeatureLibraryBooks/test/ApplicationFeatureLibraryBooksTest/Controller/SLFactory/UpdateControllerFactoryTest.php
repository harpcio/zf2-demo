<?php

namespace ApplicationFeatureLibraryBooksTest\Controller\SLFactory;

use ApplicationFeatureLibraryBooks\Controller\UpdateController;
use ApplicationFeatureLibraryBooks\Controller\SLFactory\UpdateControllerSLFactory;
use Test\Bootstrap;
use Zend\Mvc\Controller\ControllerManager;

class UpdateControllerFactoryTest extends \PHPUnit_Framework_TestCase
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