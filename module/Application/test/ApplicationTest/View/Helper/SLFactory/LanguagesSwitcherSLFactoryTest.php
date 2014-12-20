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

use Application\View\Helper\LanguagesSwitcher;
use Application\View\Helper\SLFactory\LanguagesSwitcherSLFactory;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Test\Bootstrap;
use Zend\Mvc\Application;
use Zend\Mvc\Router\Http\RouteMatch;
use Zend\View\HelperPluginManager;

class LanguageSwitcherSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LanguagesSwitcherSLFactory
     */
    private $testedObj;

    /**
     * @var MockObject
     */
    private $applicationMock;

    public function setUp()
    {
        $this->applicationMock = $this->getMockBuilder(Application::class)
            ->setMethods(['getMvcEvent', 'getRouteMatch'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->testedObj = new LanguagesSwitcherSLFactory();
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();

        Bootstrap::setupServiceManager();
    }

    public function testCreateService()
    {
        $this->applicationMock->expects($this->once())
            ->method('getMvcEvent')
            ->willReturnSelf();

        $this->applicationMock->expects($this->once())
            ->method('getRouteMatch')
            ->willReturn(new RouteMatch([]));

        $sl = Bootstrap::getServiceManager();
        $sl->setAllowOverride(true);
        $sl->setService('Application', $this->applicationMock);
        $sl->setAllowOverride(false);

        $helperPluginManager = new HelperPluginManager();
        $helperPluginManager->setServiceLocator($sl);

        $result = $this->testedObj->createService($helperPluginManager);

        $this->assertInstanceOf(LanguagesSwitcher::class, $result);
    }
}