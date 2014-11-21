<?php

namespace AuthTest\Service\SLFactory;

use Auth\Service\LogoutService;
use Auth\Service\SLFactory\LogoutServiceSLFactory;
use Test\Bootstrap;

class LogoutServiceSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LogoutServiceSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new LogoutServiceSLFactory();
    }

    public function testCreateService()
    {
        $result = $this->testedObj->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(LogoutService::class, $result);
    }
}