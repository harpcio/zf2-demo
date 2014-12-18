<?php

namespace Application\View\Helper;

use Application\Model\LangConfig;
use Zend\Mvc\Router\Http\RouteMatch;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Renderer\PhpRenderer;

class LanguagesSwitcher extends AbstractHelper
{
    /**
     * @var RouteMatch
     */
    private $routeMatch;

    /**
     * @var LangConfig
     */
    private $config;

    public function __construct(RouteMatch $routeMatch = null, LangConfig $config)
    {
        $this->routeMatch = $routeMatch;
        $this->config = $config;
    }

    public function __invoke()
    {
        if (!$this->config->getAvailableLanguages()) {
            return '';
        }

        /** @var PhpRenderer $view */
        $view = $this->getView();
        $appLang = $this->config->findLanguageByLocale(\Locale::getDefault());
        list($params, $routeName) = $this->prepareParamsAndRouteName();

        $languages = '';
        foreach ($this->config->getAvailableLanguages() as $lang) {
            list($nameOfLanguage, $nameOfCountry, $countryCode) = $this->prepareDisplayProperties($lang);
            $params = $this->prepareLanguageInParams($params, $lang);

            $url = $view->url($routeName, $params);

            $liClass = '';
            if ($lang === $appLang) {
                $liClass = ' class="disabled"';
            }

            $languages .= str_replace(
                ['{url}', '{nameOfLanguage}', '{nameOfCountry}', '{countryCode}', '{liClass}'],
                [$url, $nameOfLanguage, $nameOfCountry, $countryCode, $liClass],
                $this->getElementTemplate()
            );
        }

        $selectedLanguage = \Locale::getDisplayName($appLang);
        $countryCode = \Locale::getRegion($this->config->findLocaleByLanguage($appLang));

        $template = str_replace(
            ['{availableLanguages}', '{currentLanguage}', '{currentCountryCode}'],
            [$languages, $selectedLanguage, $countryCode],
            $this->getMainTemplate()
        );

        return $template;
    }

    /**
     * @return array
     */
    private function prepareParamsAndRouteName()
    {
        // default $params and $routeName
        $params['__NAMESPACE__'] = 'Application\\Controller';
        $params['action'] = null;
        $params['controller'] = 'index';
        $routeName = 'home';

        // when error occurred (404) we don't have routeMatch
        if ($this->routeMatch) {
            $params = $this->routeMatch->getParams();
            if ($params['action'] === 'index') {
                $params['action'] = null;
            }
            $params['controller'] = $params['__CONTROLLER__'];

            $routeName = $this->routeMatch->getMatchedRouteName();
        }

        return [$params, $routeName];
    }

    /**
     * @param array  $params
     * @param string $lang
     *
     * @return array
     */
    private function prepareLanguageInParams(array $params, $lang)
    {
        // when error occurred (404) we don't have routeMatch
        if ($this->routeMatch) {
            // we change lang only there when lang parameter exists
            if ($this->routeMatch->getParam('lang') !== null) {
                $params['lang'] = $lang;
            }
        } else {
            $params['lang'] = $lang;
        }

        // if default app language is the same as lang and shouldRedirect is disabled
        if ($this->config->getDefaultLanguage() === $lang && !$this->config->shouldRedirectToRecognizedLanguage()) {
            $params['lang'] = '';
        }

        return $params;
    }

    private function prepareDisplayProperties($lang)
    {
        $locale = $this->config->findLocaleByLanguage($lang);

        $nameOfLanguage = \Locale::getDisplayName($lang, $locale);
        $nameOfCountry = \Locale::getDisplayLanguage($lang, \Locale::getDefault());
        $countryCode = \Locale::getRegion($locale);

        return [$nameOfLanguage, $nameOfCountry, $countryCode];
    }

    /**
     * @return string
     */
    private function getMainTemplate()
    {
        return <<<HTML
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <span class="glyphicon bfh-flag-{currentCountryCode}"></span>
        {currentLanguage}
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        {availableLanguages}
    </ul>
</li>
HTML;
    }

    /**
     * @return string
     */
    private function getElementTemplate()
    {
        return <<<HTML
<li{liClass}><a href="{url}" title="{nameOfLanguage} ({nameOfCountry})"><span class="glyphicon bfh-flag-{countryCode}"></span>{nameOfLanguage}</a></li>
HTML;
    }
}