<?php

namespace Module\AuthTest\Controller\SLFactory;

use Module\Auth\Controller\LogoutController;
use Module\Auth\Controller\SLFactory\LogoutControllerSLFactory;
use Test\Bootstrap;
use Zend\Mvc\Controller\ControllerManager;

class LogoutControllerSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LogoutControllerSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new LogoutControllerSLFactory();
    }

    public function testCreateService()
    {
        $controllerManager = new ControllerManager();
        $controllerManager->setServiceLocator(Bootstrap::getServiceManager());

        $result = $this->testedObj->createService($controllerManager);

        $this->assertInstanceOf(LogoutController::class, $result);
    }
}