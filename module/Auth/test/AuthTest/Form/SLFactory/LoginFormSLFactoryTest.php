<?php

namespace AuthTest\Form\SLFactory;

use Auth\Form\LoginForm;
use Auth\Form\SLFactory\LoginFormSLFactory;
use Test\Bootstrap;

class LoginFormSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LoginFormSLFactory
     */
    private $testedObject;

    public function setUp()
    {
        $this->testedObject = new LoginFormSLFactory();
    }

    public function testCreateService()
    {
        $result = $this->testedObject->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(LoginForm::class, $result);
    }
}