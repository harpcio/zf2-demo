<?php

namespace ApplicationTest\View\Helper\SLFactory;

use Application\View\Helper\LanguagesSwitcher;
use Application\View\Helper\SLFactory\LanguagesSwitcherSLFactory;
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

    public function setUp()
    {
        $this->testedObj = new LanguagesSwitcherSLFactory();
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();

        Bootstrap::setupServiceManager();
    }

    public function testCreateService()
    {
        /** @var Application $app */
        $app = Bootstrap::getServiceManager()->get('Application');
        $app->bootstrap();
        $app->getMvcEvent()->setRouteMatch(new RouteMatch([]));

        $helperPluginManager = new HelperPluginManager();
        $helperPluginManager->setServiceLocator(Bootstrap::getServiceManager());

        $result = $this->testedObj->createService($helperPluginManager);

        $this->assertInstanceOf(LanguagesSwitcher::class, $result);
    }
}