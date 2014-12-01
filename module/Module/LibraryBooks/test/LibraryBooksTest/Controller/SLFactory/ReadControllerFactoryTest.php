<?php

namespace Module\LibraryBooksTest\Controller\SLFactory;

use Module\LibraryBooks\Controller\ReadController;
use Module\LibraryBooks\Controller\SLFactory\ReadControllerSLFactory;
use Test\Bootstrap;
use Zend\Mvc\Controller\ControllerManager;

class ReadControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ReadControllerSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new ReadControllerSLFactory();
    }

    public function testCreateService()
    {
        $controllerManager = new ControllerManager();
        $controllerManager->setServiceLocator(Bootstrap::getServiceManager());

        $result = $this->testedObj->createService($controllerManager);

        $this->assertInstanceOf(ReadController::class, $result);
    }
}