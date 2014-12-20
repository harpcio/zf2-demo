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

namespace Application\Model;

class LangConfig
{
    /**
     * @var string
     */
    private $defaultLanguage;

    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * @var array
     */
    private $availableLanguages = [];

    /**
     * @var array
     */
    private $languageToLocaleMap = [];

    /**
     * @var bool
     */
    private $shouldRedirectToRecognizedLanguage = false;

    public function __construct(array $config)
    {
        if (isset($config['language'])) {
            $langConfig = $config['language'];

            if (!isset($langConfig['default']) || !is_array($langConfig['default'])) {
                throw new \InvalidArgumentException(
                    "Options [language][default] must exist and must be array (ie. ['en' => 'en_GB'])"
                );
            }

            $this->defaultLanguage = key($langConfig['default']);
            $this->defaultLocale = reset($langConfig['default']);

            if (!isset($langConfig['available']) || !is_array($langConfig['available'])) {
                throw new \InvalidArgumentException(
                    "Options [language][available] must exist and must be array (ie. ['de' => 'de_DE', 'pl' => 'pl_PL', 'pt-br' => 'pt_BR])"
                );
            }

            $this->languageToLocaleMap = $langConfig['available'];
            $this->availableLanguages = array_keys($this->languageToLocaleMap);

            if (isset($langConfig['should_redirect_to_recognized_language'])) {
                $this->shouldRedirectToRecognizedLanguage = (bool)$langConfig['should_redirect_to_recognized_language'];
            }
        }
    }

    /**
     * @return array
     */
    public function getAvailableLanguages()
    {
        return $this->availableLanguages;
    }

    /**
     * @return string
     */
    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }

    /**
     * @return string
     */
    public function getDefaultLocale()
    {
        return $this->defaultLocale;
    }

    /**
     * @return boolean
     */
    public function shouldRedirectToRecognizedLanguage()
    {
        return $this->shouldRedirectToRecognizedLanguage;
    }

    /**
     * @param string $lang
     *
     * @return string|bool
     */
    public function findLocaleByLanguage($lang)
    {
        if (isset($this->languageToLocaleMap[$lang])) {
            return $this->languageToLocaleMap[$lang];
        }

        return false;
    }

    public function findLanguageByLocale($locale)
    {
        return array_search($locale, $this->languageToLocaleMap);
    }

}