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

use Application\Listener\Lang\LangRecognizer;
use Application\Model\LangConfig;
use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Http\RouteMatch;

class LangRecognizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LangRecognizer
     */
    private $testedObject;

    /**
     * @var string
     */
    private $defaultLocale;

    public function setUp()
    {
        $this->defaultLocale = \Locale::getDefault();
    }

    public function tearDown()
    {
        \Locale::setDefault($this->defaultLocale);
    }

    private function prepareTestedObject(array $config)
    {
        $this->testedObject = new LangRecognizer(new LangConfig($config));
    }

    private function prepareConfig($shouldRedirectToRecognizedLanguage = false)
    {
        return [
            'language' => [
                'default' => [
                    'en' => 'en_GB'
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

    public function testRecognize_WhenConfigIsEmpty()
    {
        $this->prepareTestedObject([]);

        $event = new MvcEvent();

        $result = $this->testedObject->recognize($event);

        $this->assertFalse($result);
    }

    /**
     * @dataProvider dataProviderForTestRecognize_WhenShouldRedirectToRecognizedLanguageIsDisabled
     *
     * @param string $browserLangLocale
     * @param string $routeMatchLang
     * @param array  $expectedResult
     */
    public function testRecognize_WhenShouldRedirectToRecognizedLanguageIsDisabled(
        $browserLangLocale,
        $routeMatchLang,
        $expectedResult
    ) {
        $this->prepareTestedObject($this->prepareConfig(false));

        $request = new Request();
        $request->getHeaders()->addHeaderLine('Accept-Language', $browserLangLocale);

        $paramsBefore = [
            '__NAMESPACE__' => 'Module\\Some',
            'controller' => 'TestController',
            'action' => 'index',
            'lang' => $routeMatchLang,
            '__CONTROLLER__' => 'test',
        ];

        $routeMatch = new RouteMatch($paramsBefore);

        $matchedRouteName = 'some\\test';
        $routeMatch->setMatchedRouteName($matchedRouteName);

        $event = new MvcEvent();
        $event->setRequest($request);
        $event->setResponse(new Response());
        $event->setRouteMatch($routeMatch);

        $result = $this->testedObject->recognize($event);

        $this->assertSame($expectedResult, $result);
    }

    public function dataProviderForTestRecognize_WhenShouldRedirectToRecognizedLanguageIsDisabled()
    {
        return [
            'browser locale: de_DE, router match lang: en, we should get: en' =>
                [
                    'de_DE',
                    'en',
                    [
                        'en',
                        'en_GB',
                        'en',
                        null
                    ]
                ],
            'browser locale: en_GB, router match lang: pl, we should get: pl' =>
                [
                    'en_GB',
                    'pl',
                    [
                        'pl',
                        'pl_PL',
                        'pl',
                        null
                    ]
                ],
            'browser locale: pl_PL, router match lang: de, we should get: de' =>
                [
                    'pl_PL',
                    'de',
                    [
                        'de',
                        'de_DE',
                        'de',
                        null
                    ]
                ],
            'browser locale: en_GB, router match lang: pt-br, we should get: pt-br' =>
                [
                    'en_GB',
                    'pt-br',
                    [
                        'pt-br',
                        'pt_BR',
                        'pt-br',
                        null
                    ]
                ],
            'browser locale: de_DE, router match lang: fr, we should get: en' =>
                [
                    'de_DE',
                    'fr',
                    [
                        'en',
                        'en_GB',
                        false,
                        null
                    ]
                ],
            'browser locale: pl_PL, router match lang: "", we should get: en' =>
                [
                    'pl_PL',
                    '',
                    [
                        'en',
                        'en_GB',
                        null,
                        null
                    ]
                ],
            'browser locale: fr_FR, router match lang: "", we should get: en' =>
                [
                    'fr_FR',
                    '',
                    [
                        'en',
                        'en_GB',
                        null,
                        null
                    ]
                ],
            'browser locale: pt_BR, router match lang: "", we should get: en' =>
                [
                    'pt_BR',
                    '',
                    [
                        'en',
                        'en_GB',
                        null,
                        null
                    ]
                ],
        ];
    }

    /**
     * @dataProvider dataProviderForTestRecognize_WhenShouldRedirectToRecognizedLanguageIsEnabled
     *
     * @param string $browserLangLocale
     * @param string $routeMatchLang
     * @param array  $expectedResult
     */
    public function testRecognize_WhenShouldRedirectToRecognizedLanguageIsEnabled(
        $browserLangLocale,
        $routeMatchLang,
        $expectedResult
    ) {
        $this->prepareTestedObject($this->prepareConfig(true));

        $request = new Request();
        $request->getHeaders()->addHeaderLine('Accept-Language', $browserLangLocale);

        $paramsBefore = [
            '__NAMESPACE__' => 'Module\\Some',
            'controller' => 'TestController',
            'action' => 'index',
            'lang' => $routeMatchLang,
            '__CONTROLLER__' => 'test',
        ];

        $routeMatch = new RouteMatch($paramsBefore);

        $matchedRouteName = 'some\\test';
        $routeMatch->setMatchedRouteName($matchedRouteName);

        $event = new MvcEvent();
        $event->setRequest($request);
        $event->setResponse(new Response());
        $event->setRouteMatch($routeMatch);

        $result = $this->testedObject->recognize($event);

        $this->assertSame($expectedResult, $result);
    }

    public function dataProviderForTestRecognize_WhenShouldRedirectToRecognizedLanguageIsEnabled()
    {
        return [
            'browser locale: de_DE, router match lang: en, we should get: en' =>
                [
                    'de_DE',
                    'en',
                    [
                        'en',
                        'en_GB',
                        'en',
                        'de'
                    ]
                ],
            'browser locale: en_GB, router match lang: pl, we should get: pl' =>
                [
                    'en_GB',
                    'pl',
                    [
                        'pl',
                        'pl_PL',
                        'pl',
                        'en'
                    ]
                ],
            'browser locale: pl_PL, router match lang: de, we should get: de' =>
                [
                    'pl_PL',
                    'de',
                    [
                        'de',
                        'de_DE',
                        'de',
                        'pl'
                    ]
                ],
            'browser locale: pt_BR, router match lang: de, we should get: de' =>
                [
                    'pt_BR',
                    'de',
                    [
                        'de',
                        'de_DE',
                        'de',
                        'pt-br'
                    ]
                ],
            'browser locale: de_DE, router match lang: fr, we should get: en' =>
                [
                    'de_DE',
                    'fr',
                    [
                        'de',
                        'de_DE',
                        false,
                        'de'
                    ]
                ],
            'browser locale: pl_PL, router match lang: "", we should get: pl' =>
                [
                    'pl_PL',
                    '',
                    [
                        'pl',
                        'pl_PL',
                        null,
                        'pl'
                    ]
                ],
            'browser locale: de_DE, router match lang: "", we should get: de' =>
                [
                    'de_DE',
                    '',
                    [
                        'de',
                        'de_DE',
                        null,
                        'de'
                    ]
                ],
            'browser locale: en_GB, router match lang: "", we should get: en' =>
                [
                    'en_GB',
                    '',
                    [
                        'en',
                        'en_GB',
                        null,
                        'en'
                    ]
                ],
            'browser locale: fr_FR, router match lang: "", we should get: en' =>
                [
                    'fr_FR',
                    '',
                    [
                        'en',
                        'en_GB',
                        null,
                        null
                    ]
                ],
        ];
    }
}