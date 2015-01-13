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

namespace ApplicationCoreLangTest\Model;

use ApplicationCoreLang\Model\LangConfig;

class LangConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor_WithEmptyConfig()
    {
        $testedObject = new LangConfig([]);

        $this->assertNull($testedObject->getDefaultLanguage());
        $this->assertNull($testedObject->getDefaultLocale());
        $this->assertEmpty($testedObject->getAvailableLanguages());
        $this->assertFalse($testedObject->findLanguageByLocale('en_GB'));
        $this->assertFalse($testedObject->findLocaleByLanguage('en'));
        $this->assertFalse($testedObject->shouldRedirectToRecognizedLanguage());
    }

    public function testConstructor_WithEmptyDefaultKey()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            "Options [language][default] must exist and must be array (ie. ['en' => 'en_GB'])"
        );

        new LangConfig(
            [
                'language' => [
                    'default' => null
                ]
            ]
        );
    }

    public function testConstructor_WithEmptyAvailableKey()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            "Options [language][available] must exist and must be array (ie. ['de' => 'de_DE', 'pl' => 'pl_PL', 'pt-br' => 'pt_BR])"
        );

        new LangConfig(
            [
                'language' => [
                    'default' => [
                        'en' => 'en_GB'
                    ],
                    'available' => null
                ]
            ]
        );
    }

    public function testConstructor_WithNotEmptyConfig_WhenShouldRedirectIsDisabled()
    {
        $testedObject = new LangConfig($this->prepareConfig(false));

        $this->assertSame('en', $testedObject->getDefaultLanguage());
        $this->assertSame('en_GB', $testedObject->getDefaultLocale());
        $this->assertSame(['de', 'en', 'pl', 'pt-br'], $testedObject->getAvailableLanguages());
        $this->assertSame('de', $testedObject->findLanguageByLocale('de_DE'));
        $this->assertSame('pt_BR', $testedObject->findLocaleByLanguage('pt-br'));
        $this->assertFalse($testedObject->shouldRedirectToRecognizedLanguage());
    }

    public function testConstructor_WithNotEmptyConfig_WhenShouldRedirectIsEnabled()
    {
        $testedObject = new LangConfig($this->prepareConfig(true));

        $this->assertTrue($testedObject->shouldRedirectToRecognizedLanguage());
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
}