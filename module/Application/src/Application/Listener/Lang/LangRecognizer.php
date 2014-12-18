<?php

namespace Application\Listener\Lang;

use Application\Model\LangConfig;
use Zend\Http\Header\Accept\FieldValuePart\LanguageFieldValuePart;
use Zend\Http\Header\AcceptLanguage;
use Zend\Http\Headers;
use Zend\Http\PhpEnvironment\Request;
use Zend\Mvc\MvcEvent;

class LangRecognizer
{

    /**
     * @var LangConfig
     */
    private $config;

    /**
     * @param LangConfig $config
     */
    public function __construct(LangConfig $config)
    {
        $this->config = $config;
    }

    public function recognize(MvcEvent $event)
    {
        if (!$this->config->getAvailableLanguages()) {
            return false;
        }

        $lang = $this->config->getDefaultLanguage();

        /** @var Request $request */
        $request = $event->getRequest();

        $routeMatchLang = $this->getRouteMatchLanguage($event);

        $browserLang = null;
        if ($this->config->shouldRedirectToRecognizedLanguage()) {
            $browserLang = $this->getBrowseAcceptLanguage($request->getHeaders());
        }

        if ($routeMatchLang || $browserLang) {
            $lang = $routeMatchLang ? $routeMatchLang : $browserLang;
        }

        $locale = $this->config->findLocaleByLanguage($lang);

        return [$lang, $locale, $routeMatchLang, $browserLang];
    }

    /**
     * @param MvcEvent $event
     *
     * @return string|false|null
     */
    private function getRouteMatchLanguage(MvcEvent $event)
    {
        if (($routeMatchLang = $event->getRouteMatch()->getParam('lang'))) {
            if (\Locale::lookup($this->config->getAvailableLanguages(), $routeMatchLang)) {
                return $routeMatchLang;
            }
            return false;
        }
        return null;
    }

    /**
     * @param Headers $headers
     *
     * @return string|null
     */
    private function getBrowseAcceptLanguage(Headers $headers)
    {
        if ($headers->has('Accept-Language')) {
            /** @var AcceptLanguage $acceptLanguageHeader */
            $acceptLanguageHeader = $headers->get('Accept-Language');
            $locales = $acceptLanguageHeader->getPrioritized();

            $languages = $this->config->getAvailableLanguages();

            /** @var LanguageFieldValuePart $locale */
            foreach ($locales as $locale) {
                // Loop through all locales, highest priority first
                if (($browserLang = \Locale::lookup($languages, $locale->getRaw()))) {
                    return $browserLang;
                }
            }
        }

        return null;
    }
}