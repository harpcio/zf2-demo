<?php

namespace AuthTest\Service\Storage\SLFactory;

use Auth\Service\Storage\DbStorage;
use Auth\Service\Storage\SLFactory\DbStorageSLFactory;
use Test\Bootstrap;

class DbStorageSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DbStorageSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new DbStorageSLFactory();
    }

    public function testCreateService()
    {
        $result = $this->testedObj->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(DbStorage::class, $result);
    }
}