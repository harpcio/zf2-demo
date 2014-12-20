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

namespace AclTest\Service\Listener\SLFactory;

use Acl\Service\Listener\CheckAccessListener;
use Acl\Service\Listener\SLFactory\CheckAccessListenerSLFactory;
use Test\Bootstrap;

class CheckAccessListenerSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CheckAccessListenerSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new CheckAccessListenerSLFactory();
    }

    public function testCreateService()
    {
        $result = $this->testedObj->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(CheckAccessListener::class, $result);
    }
}