<?php

namespace ApplicationTest\Listener\Lang\SLFactory;

use Application\Listener\Lang\LangListener;
use Application\Listener\Lang\SLFactory\LangListenerSLFactory;
use Test\Bootstrap;

class LangListenerSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LangListenerSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new LangListenerSLFactory();
    }

    public function testCreateService()
    {
        $result = $this->testedObj->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(LangListener::class, $result);
    }
}