<?php

namespace AclTest\Service\SLFactory;

use Acl\Service\AclFactory;
use Acl\Service\SLFactory\AclFactorySLFactory;
use Test\Bootstrap;

class AclFactorySLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AclFactorySLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new AclFactorySLFactory();
    }

    public function testCreateService()
    {
        $result = $this->testedObj->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(AclFactory::class, $result);
    }
}