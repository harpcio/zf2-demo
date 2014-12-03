<?php

namespace LibraryTest\Logger\SLFactory;

use Library\Logger\SLFactory\LoggerSLFactory;
use Test\Bootstrap;
use Zend\Log\LoggerInterface;

class IdentityViewHelperSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LoggerSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new LoggerSLFactory();
    }

    public function testCreateService()
    {
        $result = $this->testedObj->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(LoggerInterface::class, $result);
    }
}