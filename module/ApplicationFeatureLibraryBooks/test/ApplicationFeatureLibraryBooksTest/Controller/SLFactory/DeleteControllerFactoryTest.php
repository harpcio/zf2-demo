<?php

namespace ApplicationFeatureLibraryBooksTest\Controller\SLFactory;

use ApplicationFeatureLibraryBooks\Controller\DeleteController;
use ApplicationFeatureLibraryBooks\Controller\SLFactory\DeleteControllerSLFactory;
use Test\Bootstrap;
use Zend\Mvc\Controller\ControllerManager;

class DeleteControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DeleteControllerSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new DeleteControllerSLFactory();
    }

    public function testCreateService()
    {
        $controllerManager = new ControllerManager();
        $controllerManager->setServiceLocator(Bootstrap::getServiceManager());

        $result = $this->testedObj->createService($controllerManager);

        $this->assertInstanceOf(DeleteController::class, $result);
    }
}