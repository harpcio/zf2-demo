<?php

namespace ApplicationFeatureLibraryBooksTest\Controller\SLFactory;

use ApplicationFeatureLibraryBooks\Controller\IndexController;
use ApplicationFeatureLibraryBooks\Controller\SLFactory\IndexControllerSLFactory;
use Test\Bootstrap;
use Zend\Mvc\Controller\ControllerManager;

class IndexControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IndexControllerSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new IndexControllerSLFactory();
    }

    public function testCreateService()
    {
        $controllerManager = new ControllerManager();
        $controllerManager->setServiceLocator(Bootstrap::getServiceManager());

        $result = $this->testedObj->createService($controllerManager);

        $this->assertInstanceOf(IndexController::class, $result);
    }
}