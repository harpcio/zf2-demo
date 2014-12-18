<?php

namespace ApplicationTest\Listener\Lang\SLFactory;

use Application\Listener\Lang\LangRedirector;
use Application\Listener\Lang\SLFactory\LangRedirectorSLFactory;
use Test\Bootstrap;

class LangRedirectorSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LangRedirectorSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new LangRedirectorSLFactory();
    }

    public function testCreateService()
    {
        $result = $this->testedObj->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(LangRedirector::class, $result);
    }
}