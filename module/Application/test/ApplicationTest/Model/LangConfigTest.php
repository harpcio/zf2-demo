<?php

namespace ApplicationTest\Model;

use Application\Model\LangConfig;

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