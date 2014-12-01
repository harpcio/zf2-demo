<?php

namespace AclTest\Service;

use Acl\Service\AclFactory;
use Test\Bootstrap;
use Zend\Permissions\Acl\Acl;

class AclFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AclFactory
     */
    private $testedObject;

    /**
     * @var array
     */
    private $modules;

    /**
     * @var array
     */
    private $config;

    public function setUp()
    {
        $this->modules = Bootstrap::getServiceManager()->get('ApplicationConfig')['modules'];
        $this->config = Bootstrap::getServiceManager()->get('Config')['acl'];

        $this->testedObject = new AclFactory($this->modules, $this->config);
    }

    public function testCreate()
    {
        $result = $this->testedObject->create();

        $this->assertInstanceOf(Acl::class, $result);
        $this->assertCount(count(array_keys($this->modules)), $result->getResources());
        $this->assertCount(count(array_keys($this->config)), $result->getRoles());
    }

}