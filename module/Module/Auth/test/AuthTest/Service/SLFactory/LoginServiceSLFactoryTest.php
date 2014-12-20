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

namespace Module\AuthTest\Service\SLFactory;

use Module\Auth\Service\LoginService;
use Module\Auth\Service\SLFactory\LoginServiceSLFactory;
use Test\Bootstrap;

class LoginServiceSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LoginServiceSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new LoginServiceSLFactory();
    }

    public function testCreateService()
    {
        $result = $this->testedObj->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(LoginService::class, $result);
    }
}