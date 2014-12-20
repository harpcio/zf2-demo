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

namespace Application\Listener\Lang;

use Application\Model\LangConfig;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\SimpleRouteStack;

class LangRedirector
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

    /**
     * @param MvcEvent $event
     * @param string   $lang
     * @param string   $routeMatchLang
     *
     * @return bool
     */
    public function checkRedirect(MvcEvent $event, $lang, $routeMatchLang)
    {
        if ($this->checkRedirectIfShouldRedirectOptionIsDisabled($event, $routeMatchLang)) {
            return true;
        }

        if ($this->checkRedirectIfShouldRedirectOptionIsEnabled($event, $lang, $routeMatchLang)) {
            return true;
        }

        $this->setLangToRouterIfLangIsDifferentFromDefaultLangOrShouldRedirectOptionIsEnabled($event, $lang);

        return false;
    }

    /**
     * If shouldRedirectToRecognizedLanguage is enabled
     *    then do nothing
     *
     * If default lang is EN
     *    and we try to go here "/en"
     *       or here "/tw" (Taiwan, not available language)
     * then
     *    redirect to "/"
     * else
     *    do nothing
     *
     * @param MvcEvent $event
     * @param string   $routeMatchLang
     *
     * @return bool
     */
    private function checkRedirectIfShouldRedirectOptionIsDisabled(MvcEvent $event, $routeMatchLang)
    {
        if ($this->config->shouldRedirectToRecognizedLanguage()) {
            return false;
        }

        if ($routeMatchLang === $this->config->getDefaultLanguage() || $routeMatchLang === false) {
            $this->redirectToRightLanguage($event, '');

            return true;
        }

        return false;
    }

    /**
     * If shouldRedirectToRecognizedLanguage is disabled
     *    then do nothing
     *
     * If we want to go here: "/tw" (Taiwan language is not available)
     * or
     * If we want to go here: "/"
     *    if browser language is available (ie. PL, EN, DE)
     *        then redirect to "/(pl|en|de)"
     *
     *    if browser language is not available (ie. TW)
     *        then redirect to default language "/en"
     *
     *    if new route match don't have lang parameter in settings
     *        then do nothing
     *
     * @param MvcEvent $event
     * @param string   $lang
     * @param string   $routeMatchLang
     *
     * @return bool
     */
    private function checkRedirectIfShouldRedirectOptionIsEnabled(MvcEvent $event, $lang, $routeMatchLang)
    {
        if (!$this->config->shouldRedirectToRecognizedLanguage()) {
            return false;
        }

        if ($routeMatchLang !== $lang) {
            if ($result = $this->redirectToRightLanguage($event, $lang)) {
                return true;
            }
        }

        return false;
    }

    /**
     * If shouldRedirectToRecognizedLanguage is enabled
     * or
     * If we are here: "/pl" and default language is different (ie. EN)
     *    then set lang to router, to achieve all urls with this language
     *
     * @param MvcEvent $event
     * @param string   $lang
     */
    private function setLangToRouterIfLangIsDifferentFromDefaultLangOrShouldRedirectOptionIsEnabled(
        MvcEvent $event,
        $lang
    ) {
        if ($this->config->shouldRedirectToRecognizedLanguage()
            || $lang !== $this->config->getDefaultLanguage()
        ) {
            /** @var SimpleRouteStack $router */
            $router = $event->getRouter();
            $router->setDefaultParam('lang', $lang);
        }
    }

    /**
     * @param MvcEvent $event
     * @param string   $lang
     *
     * @return bool
     */
    private function redirectToRightLanguage(MvcEvent $event, $lang)
    {
        $routeMatch = $event->getRouteMatch();

        // We need to omit those routes without lang param to avoid infinity redirect loop
        if ($routeMatch->getParam('lang') === null) {
            return false;
        }

        $params = $this->prepareParams($routeMatch, $lang);

        $router = $event->getRouter();
        $url = $router->assemble($params, ['name' => $routeMatch->getMatchedRouteName()]);

        /** @var Response $response */
        $response = $event->getResponse();
        $response->setStatusCode(302);
        $response->getHeaders()->addHeaderLine('Location', $url);
        $event->stopPropagation();

        return true;
    }

    private function prepareParams(RouteMatch $routeMatch, $lang)
    {
        $params = $routeMatch->getParams();
        $params['lang'] = $lang;

        // We want to avoid this situation ie. : "/en/auth/login/index"
        // Otherwise we get: "/en/auth/login", nice and clear
        if ($params['action'] === 'index') {
            $params['action'] = null;
        }

        // We need to set this, because otherwise we achieve this:
        // "/en/auth/Module\\Auth\\Controller\\LoginController"
        $params['controller'] = $params['__CONTROLLER__'];

        return $params;
    }
}