<?php

namespace ApplicationTest\View\Helper;

use Application\Model\LangConfig;
use Application\View\Helper\LanguagesSwitcher;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Mvc\Router\Http\RouteMatch;
use Zend\View\Renderer\PhpRenderer;

class LanguagesSwitcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LanguagesSwitcher
     */
    private $testedObject;

    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * @var MockObject
     */
    private $routeMatchMock;

    /**
     * @var MockObject
     */
    private $viewMock;

    public function setUp()
    {
        $this->prepareMocks();

        $this->defaultLocale = \Locale::getDefault();
    }

    public function tearDown()
    {
        parent::tearDown();

        \Locale::setDefault($this->defaultLocale);
    }

    private function prepareMocks()
    {
        $this->routeMatchMock = $this->getMockBuilder(RouteMatch::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->viewMock = $this->getMockBuilder(PhpRenderer::class)
            ->setMethods(['url'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function prepareTestedObject($config, $routeMatch = true)
    {
        if ($routeMatch) {
            $this->testedObject = new LanguagesSwitcher($this->routeMatchMock, new LangConfig($config));
        } else {
            $this->testedObject = new LanguagesSwitcher(null, new LangConfig($config));
        }

        $this->testedObject->setView($this->viewMock);
    }

    private function prepareConfig($shouldRedirectToRecognizedLanguage = false)
    {
        return [
            'language' => [
                'default' => [
                    'en' => 'en_GB',
                ],
                'available' => [
                    'de' => 'de_DE',
                    'en' => 'en_GB',
                    'pl' => 'pl_PL',
                    'pt-br' => 'pt_BR'
                ],
                'should_redirect_to_recognized_language' => $shouldRedirectToRecognizedLanguage,
            ],
        ];
    }

    public function testInvokeMethod_WhenConfigIsEmpty()
    {
        $this->prepareTestedObject([]);

        $result = $this->testedObject->__invoke();

        $this->assertSame($result, '');
    }

    public function testInvokeMethod_WhenShouldRedirectToRecognizedLanguageIsFalse()
    {
        $this->prepareTestedObject($this->prepareConfig());

        \Locale::setDefault('en_GB');

        $this->routeMatchMock->expects($this->once())
            ->method('getParams')
            ->willReturn(
                [
                    '__NAMESPACE__' => 'Module\\Some',
                    'controller' => 'TestController',
                    'action' => 'index',
                    'lang' => '',
                    '__CONTROLLER__' => 'test',
                ]
            );

        $this->routeMatchMock->expects($this->once())
            ->method('getMatchedRouteName')
            ->willReturn('someRoute');

        $this->viewMock->expects($this->at(0))
            ->method('url')
            ->willReturn('/de/some/test');

        $this->viewMock->expects($this->at(1))
            ->method('url')
            ->willReturn('/some/test');

        $this->viewMock->expects($this->at(2))
            ->method('url')
            ->willReturn('/pl/some/test');

        $this->viewMock->expects($this->at(3))
            ->method('url')
            ->willReturn('/pt-br/some/test');

        $result = $this->testedObject->__invoke();

        $expected = <<<HTML
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <span class="glyphicon bfh-flag-GB"></span>
        English
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="/de/some/test" title="Deutsch (German)"><span class="glyphicon bfh-flag-DE"></span>Deutsch</a></li><li class="disabled"><a href="/some/test" title="English (English)"><span class="glyphicon bfh-flag-GB"></span>English</a></li><li><a href="/pl/some/test" title="polski (Polish)"><span class="glyphicon bfh-flag-PL"></span>polski</a></li><li><a href="/pt-br/some/test" title="português (Brasil) (Portuguese)"><span class="glyphicon bfh-flag-BR"></span>português (Brasil)</a></li>
    </ul>
</li>
HTML;

        $this->assertSame($expected, $result);
    }

    public function testInvokeMethod_WhenShouldRedirectToRecognizedLanguageIsTrue()
    {
        $this->prepareTestedObject($this->prepareConfig(true));

        \Locale::setDefault('en_GB');

        $this->routeMatchMock->expects($this->once())
            ->method('getParams')
            ->willReturn(
                [
                    '__NAMESPACE__' => 'Module\\Some',
                    'controller' => 'TestController',
                    'action' => 'index',
                    'lang' => '',
                    '__CONTROLLER__' => 'test',
                ]
            );

        $this->routeMatchMock->expects($this->once())
            ->method('getMatchedRouteName')
            ->willReturn('someRoute');

        $this->viewMock->expects($this->at(0))
            ->method('url')
            ->willReturn('/de/some/test');

        $this->viewMock->expects($this->at(1))
            ->method('url')
            ->willReturn('/en/some/test');

        $this->viewMock->expects($this->at(2))
            ->method('url')
            ->willReturn('/pl/some/test');

        $this->viewMock->expects($this->at(3))
            ->method('url')
            ->willReturn('/pt-br/some/test');

        $result = $this->testedObject->__invoke();

        $expected = <<<HTML
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <span class="glyphicon bfh-flag-GB"></span>
        English
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="/de/some/test" title="Deutsch (German)"><span class="glyphicon bfh-flag-DE"></span>Deutsch</a></li><li class="disabled"><a href="/en/some/test" title="English (English)"><span class="glyphicon bfh-flag-GB"></span>English</a></li><li><a href="/pl/some/test" title="polski (Polish)"><span class="glyphicon bfh-flag-PL"></span>polski</a></li><li><a href="/pt-br/some/test" title="português (Brasil) (Portuguese)"><span class="glyphicon bfh-flag-BR"></span>português (Brasil)</a></li>
    </ul>
</li>
HTML;

        $this->assertSame($expected, $result);
    }

    public function testInvokeMethod_WhenRouteMatchIsEmptyObject()
    {
        $this->prepareTestedObject($this->prepareConfig(true), false);

        \Locale::setDefault('en_GB');

        $this->viewMock->expects($this->at(0))
            ->method('url')
            ->willReturn('/de/');

        $this->viewMock->expects($this->at(1))
            ->method('url')
            ->willReturn('/');

        $this->viewMock->expects($this->at(2))
            ->method('url')
            ->willReturn('/pl/');

        $this->viewMock->expects($this->at(3))
            ->method('url')
            ->willReturn('/pt-br/');

        $result = $this->testedObject->__invoke();

        $expected = <<<HTML
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <span class="glyphicon bfh-flag-GB"></span>
        English
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="/de/" title="Deutsch (German)"><span class="glyphicon bfh-flag-DE"></span>Deutsch</a></li><li class="disabled"><a href="/" title="English (English)"><span class="glyphicon bfh-flag-GB"></span>English</a></li><li><a href="/pl/" title="polski (Polish)"><span class="glyphicon bfh-flag-PL"></span>polski</a></li><li><a href="/pt-br/" title="português (Brasil) (Portuguese)"><span class="glyphicon bfh-flag-BR"></span>português (Brasil)</a></li>
    </ul>
</li>
HTML;

        $this->assertSame($expected, $result);
    }

}