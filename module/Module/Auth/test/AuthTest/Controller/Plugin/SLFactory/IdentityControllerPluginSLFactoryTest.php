<?php

namespace Module\AuthTest\Controller\Plugin\SLFactory;

use Module\Auth\Controller\Plugin\SLFactory\IdentityControllerPluginSLFactory;
use Test\Bootstrap;
use Zend\Mvc\Controller\ControllerManager;
use Zend\Mvc\Controller\Plugin\Identity;

class IdentityControllerPluginSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IdentityControllerPluginSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new IdentityControllerPluginSLFactory();
    }

    public function testCreateService()
    {
        $controllerManager = new ControllerManager();
        $controllerManager->setServiceLocator(Bootstrap::getServiceManager());

        $result = $this->testedObj->createService($controllerManager);

        $this->assertInstanceOf(Identity::class, $result);
    }
}