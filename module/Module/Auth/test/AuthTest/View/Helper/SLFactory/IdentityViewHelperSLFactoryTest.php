<?php

namespace Module\AuthTest\View\Helper\SLFactory;

use Module\Auth\View\Helper\SLFactory\IdentityViewHelperSLFactory;
use Test\Bootstrap;
use Zend\View\Helper\Identity;
use Zend\View\HelperPluginManager;

class IdentityViewHelperSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IdentityViewHelperSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new IdentityViewHelperSLFactory();
    }

    public function testCreateService()
    {
        $helperPluginManager = new HelperPluginManager();
        $helperPluginManager->setServiceLocator(Bootstrap::getServiceManager());

        $result = $this->testedObj->createService($helperPluginManager);

        $this->assertInstanceOf(Identity::class, $result);
    }
}