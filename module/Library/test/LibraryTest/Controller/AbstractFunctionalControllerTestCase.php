<?php

namespace LibraryTest\Controller;

use Test\Bootstrap;
use Zend\ServiceManager\ServiceManager;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

abstract class AbstractFunctionalControllerTestCase extends AbstractHttpControllerTestCase
{

    /**
     * @var ServiceManager
     */
    protected $serviceLocator;

    public function setUp()
    {
        $this->serviceLocator = null;

        $this->setApplicationConfig(
            Bootstrap::getConfig()
        );
        parent::setUp();
    }

    /**
     * Set service to service locator
     *
     * @param string $name
     * @param object $object
     *
     * @return ServiceManager
     */
    protected function setMockToServiceLocator($name, $object)
    {
        if (!$this->serviceLocator) {
            $this->serviceLocator = $this->getApplicationServiceLocator();
            $this->serviceLocator->setAllowOverride(true);
        }

        $this->serviceLocator->setService($name, $object);

        return $this->serviceLocator;
    }
}