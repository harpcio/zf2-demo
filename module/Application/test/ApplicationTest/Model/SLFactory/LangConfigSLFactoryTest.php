<?php

namespace ApplicationTest\Model\SLFactory;

use Application\Model\LangConfig;
use Application\Model\SLFactory\LangConfigSLFactory;
use Test\Bootstrap;

class LangConfigSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LangConfigSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new LangConfigSLFactory();
    }

    public function testCreateService()
    {
        $result = $this->testedObj->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(LangConfig::class, $result);
    }
}