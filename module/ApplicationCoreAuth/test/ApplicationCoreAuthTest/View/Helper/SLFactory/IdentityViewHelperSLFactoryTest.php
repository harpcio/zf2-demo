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

namespace ApplicationCoreAuthTest\View\Helper\SLFactory;

use ApplicationCoreAuth\View\Helper\SLFactory\IdentityViewHelperSLFactory;
use Test\Bootstrap;
use Zend\View\Helper\Identity;
use Zend\View\HelperPluginManager;

class IdentityViewHelperSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IdentityViewHelperSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new IdentityViewHelperSLFactory();
    }

    public function testCreateService()
    {
        $helperPluginManager = new HelperPluginManager();
        $helperPluginManager->setServiceLocator(Bootstrap::getServiceManager());

        $result = $this->testedObj->createService($helperPluginManager);

        $this->assertInstanceOf(Identity::class, $result);
    }
}