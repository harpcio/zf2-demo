<?php

namespace ApplicationTest\Listener\Log\SLFactory;

use Application\Listener\Log\LogExceptionListener;
use Application\Listener\Log\SLFactory\LogExceptionListenerSLFactory;
use Test\Bootstrap;

class LogExceptionListenerSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LogExceptionListenerSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new LogExceptionListenerSLFactory();
    }

    public function testCreateService()
    {
        $result = $this->testedObj->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(LogExceptionListener::class, $result);
    }
}