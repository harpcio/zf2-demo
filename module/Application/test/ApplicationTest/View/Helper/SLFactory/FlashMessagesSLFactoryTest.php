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

namespace ApplicationTest\View\Helper\SLFactory;

use Application\View\Helper\FlashMessages;
use Application\View\Helper\SLFactory\FlashMessagesSLFactory;
use Test\Bootstrap;
use Zend\View\HelperPluginManager;

class IdentityViewHelperSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FlashMessagesSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new FlashMessagesSLFactory();
    }

    public function testCreateService()
    {
        $helperPluginManager = new HelperPluginManager();
        $helperPluginManager->setServiceLocator(Bootstrap::getServiceManager());

        $result = $this->testedObj->createService($helperPluginManager);

        $this->assertInstanceOf(FlashMessages::class, $result);
    }
}