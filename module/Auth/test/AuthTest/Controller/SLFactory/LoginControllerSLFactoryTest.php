<?php

namespace AuthTest\Controller\SLFactory;

use Auth\Controller\LoginController;
use Auth\Controller\SLFactory\LoginControllerSLFactory;
use Test\Bootstrap;
use Zend\Mvc\Controller\ControllerManager;

class LoginControllerSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LoginControllerSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new LoginControllerSLFactory();
    }

    public function testCreateService()
    {
        $controllerManager = new ControllerManager();
        $controllerManager->setServiceLocator(Bootstrap::getServiceManager());

        $result = $this->testedObj->createService($controllerManager);

        $this->assertInstanceOf(LoginController::class, $result);
    }
}