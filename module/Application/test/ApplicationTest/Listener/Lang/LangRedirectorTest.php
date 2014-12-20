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

namespace ApplicationTest\Listener\Lang;

use Application\Listener\Lang\LangRedirector;
use Application\Model\LangConfig;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Console\SimpleRouteStack;
use Zend\Mvc\Router\Http\RouteMatch;

class LangRedirectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LangRedirector
     */
    private $testedObject;

    /**
     * @var MockObject
     */
    private $routeMock;

    private function prepareTestedObject(array $config)
    {
        $this->routeMock = $this->getMockBuilder(SimpleRouteStack::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->testedObject = new LangRedirector(new LangConfig($config));
    }

    private function prepareConfig($shouldRedirectToRecognizedLanguage = false)
    {
        return [
            'language' => [
                'default' =>
                    ['en' => 'en_GB'],
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

    /**
     * @dataProvider dataProviderForTestCheckRedirect_WhenShouldRedirectToRecognizedLanguageIsDisabled
     *
     * @param string $recognizedLang
     * @param string $routeMatchLang
     * @param string $routeMatchLangAfterRedirect
     * @param array  $expectedResult
     */
    public function testCheckRedirect_WhenShouldRedirectToRecognizedLanguageIsDisabled(
        $recognizedLang,
        $routeMatchLang,
        $routeMatchLangAfterRedirect,
        $expectedResult
    ) {
        $this->prepareTestedObject($this->prepareConfig(false));

        $paramsBefore = [
            '__NAMESPACE__' => 'Module\\Some',
            'controller' => 'TestController',
            'action' => 'index',
            'lang' => $routeMatchLang,
            '__CONTROLLER__' => 'test',
        ];

        $paramsAfter = [
            '__NAMESPACE__' => 'Module\\Some',
            'controller' => 'test',
            'action' => null,
            'lang' => $routeMatchLangAfterRedirect,
            '__CONTROLLER__' => 'test',
        ];

        $routeMatch = new RouteMatch($paramsBefore);

        $matchedRouteName = 'some\\test';
        $routeMatch->setMatchedRouteName($matchedRouteName);

        $event = new MvcEvent();
        $event->setResponse(new Response());
        $event->setRouteMatch($routeMatch);

        $uriLangPrefix = ($routeMatchLangAfterRedirect ? '/' . $routeMatchLangAfterRedirect : '');
        $expectedUri = $uriLangPrefix . '/some/test';

        if ($expectedResult) {
            $this->routeMock->expects($this->once())
                ->method('assemble')
                ->with($paramsAfter, ['name' => $matchedRouteName])
                ->willReturn($expectedUri);
        }

        $event->setRouter($this->routeMock);

        $result = $this->testedObject->checkRedirect($event, $recognizedLang, $routeMatchLang);

        $this->assertSame($expectedResult, $result);
    }

    public function dataProviderForTestCheckRedirect_WhenShouldRedirectToRecognizedLanguageIsDisabled()
    {
        /**
         * situation when recognizedLang is "de" and routeMatchLang is "en" is not possible,
         * because routeMatchLang take precedence and then recognizesLang must be also "en"
         */
        return [
            'recognizedLang: en, routeMatchLang: null, not redirect' =>
                [
                    'en',
                    null,
                    '',
                    false
                ],
            'recognizedLang: pl, routeMatchLang: null, not redirect' =>
                [
                    'pl',
                    null,
                    '',
                    false
                ],
            'recognizedLang: de, routeMatchLang: null, not redirect' =>
                [
                    'de',
                    null,
                    '',
                    false
                ],
            'recognizedLang: pt-br, routeMatchLang: null, not redirect' =>
                [
                    'pt-br',
                    null,
                    '',
                    false
                ],
            'recognizedLang: en, routeMatchLang: en, redirect to uri without lang' =>
                [
                    'en',
                    'en',
                    '',
                    true
                ],
            'recognizedLang: de, routeMatchLang: false (ie. TW), redirect to uri without lang' =>
                [
                    'de',
                    false,
                    '',
                    true
                ],
        ];
    }

    /**
     * @dataProvider dataProviderForTestCheckRedirect_WhenShouldRedirectToRecognizedLanguageIsEnabled
     *
     * @param string $recognizedLang
     * @param string $routeMatchLang
     * @param string $routeMatchLangAfterRedirect
     * @param array  $expectedResult
     */
    public function testCheckRedirect_WhenShouldRedirectToRecognizedLanguageIsEnabled(
        $recognizedLang,
        $routeMatchLang,
        $routeMatchLangAfterRedirect,
        $expectedResult
    ) {
        $this->prepareTestedObject($this->prepareConfig(true));

        $paramsBefore = [
            '__NAMESPACE__' => 'Module\\Some',
            'controller' => 'TestController',
            'action' => 'index',
            'lang' => $routeMatchLang ? $routeMatchLang : '',
            '__CONTROLLER__' => 'test',
        ];

        $paramsAfter = [
            '__NAMESPACE__' => 'Module\\Some',
            'controller' => 'test',
            'action' => null,
            'lang' => $routeMatchLangAfterRedirect,
            '__CONTROLLER__' => 'test',
        ];

        $routeMatch = new RouteMatch($paramsBefore);

        $matchedRouteName = 'some\\test';
        $routeMatch->setMatchedRouteName($matchedRouteName);

        $event = new MvcEvent();
        $event->setResponse(new Response());
        $event->setRouteMatch($routeMatch);

        $uriLangPrefix = ($routeMatchLangAfterRedirect ? '/' . $routeMatchLangAfterRedirect : '');
        $expectedUri = $uriLangPrefix . '/some/test';

        if ($expectedResult) {
            $this->routeMock->expects($this->once())
                ->method('assemble')
                ->with($paramsAfter, ['name' => $matchedRouteName])
                ->willReturn($expectedUri);
        }

        $event->setRouter($this->routeMock);

        $result = $this->testedObject->checkRedirect($event, $recognizedLang, $routeMatchLang);

        $this->assertSame($expectedResult, $result);
    }

    public function dataProviderForTestCheckRedirect_WhenShouldRedirectToRecognizedLanguageIsEnabled()
    {
        /**
         * situation when recognizedLang is "de" and routeMatchLang is "en" is not possible,
         * because routeMatchLang take precedence and then recognizesLang must be also "en"
         */
        return [
            'recognizedLang: en, routeMatchLang: null, redirect to en' =>
                [
                    'en',
                    null,
                    'en',
                    true
                ],
            'recognizedLang: pl, routeMatchLang: null, redirect to pl' =>
                [
                    'pl',
                    null,
                    'pl',
                    true
                ],
            'recognizedLang: de, routeMatchLang: null, redirect to de' =>
                [
                    'de',
                    null,
                    'de',
                    true
                ],
            'recognizedLang: pt-br, routeMatchLang: null, redirect to pt-br' =>
                [
                    'pt-br',
                    null,
                    'pt-br',
                    true
                ],
            'recognizedLang: en, routeMatchLang: en, not redirect' =>
                [
                    'en',
                    'en',
                    'en',
                    false
                ],
            'recognizedLang: de, routeMatchLang: false (ie. TW), redirect to de' =>
                [
                    'de',
                    false,
                    'de',
                    true
                ],
        ];
    }
}