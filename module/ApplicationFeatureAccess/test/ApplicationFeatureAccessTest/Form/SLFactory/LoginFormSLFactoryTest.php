<?php
/**
 * This file is part of Zf2-demo package
 *
 * @author Rafal Ksiazek <harpcio@gmail.com>
 * @copyright Rafal Ksiazek F.H.U. Studioars
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApplicationFeatureAccessTest\Form\SLFactory;

use ApplicationFeatureAccess\Form\LoginForm;
use ApplicationFeatureAccess\Form\SLFactory\LoginFormSLFactory;
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