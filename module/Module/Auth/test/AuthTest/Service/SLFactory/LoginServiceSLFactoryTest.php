<?php

namespace Module\AuthTest\Service\SLFactory;

use Module\Auth\Service\LoginService;
use Module\Auth\Service\SLFactory\LoginServiceSLFactory;
use Test\Bootstrap;

class LoginServiceSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LoginServiceSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new LoginServiceSLFactory();
    }

    public function testCreateService()
    {
        $result = $this->testedObj->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(LoginService::class, $result);
    }
}