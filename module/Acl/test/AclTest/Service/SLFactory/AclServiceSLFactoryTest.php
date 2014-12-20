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

namespace AclTest\Service\SLFactory;

use Acl\Service\AclService;
use Acl\Service\SLFactory\AclServiceSLFactory;
use Test\Bootstrap;

class AclServiceSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AclServiceSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new AclServiceSLFactory();
    }

    public function testCreateService()
    {
        $result = $this->testedObj->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(AclService::class, $result);
    }
}