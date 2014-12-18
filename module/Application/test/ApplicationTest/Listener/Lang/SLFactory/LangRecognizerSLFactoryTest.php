<?php

namespace ApplicationTest\Listener\Lang\SLFactory;

use Application\Listener\Lang\LangRecognizer;
use Application\Listener\Lang\SLFactory\LangRecognizerSLFactory;
use Test\Bootstrap;

class LangRecognizerSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LangRecognizerSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new LangRecognizerSLFactory();
    }

    public function testCreateService()
    {
        $result = $this->testedObj->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(LangRecognizer::class, $result);
    }
}