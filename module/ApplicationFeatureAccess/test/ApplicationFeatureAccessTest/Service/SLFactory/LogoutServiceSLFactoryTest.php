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

namespace ApplicationFeatureAccessTest\Service\SLFactory;

use ApplicationFeatureAccess\Service\LogoutService;
use ApplicationFeatureAccess\Service\SLFactory\LogoutServiceSLFactory;
use Test\Bootstrap;

class LogoutServiceSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LogoutServiceSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new LogoutServiceSLFactory();
    }

    public function testCreateService()
    {
        $result = $this->testedObj->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(LogoutService::class, $result);
    }
}