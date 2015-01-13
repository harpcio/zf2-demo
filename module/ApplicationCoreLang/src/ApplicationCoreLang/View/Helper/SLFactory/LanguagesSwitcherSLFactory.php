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

namespace ApplicationCoreLang\View\Helper\SLFactory;

use ApplicationCoreLang\Model\LangConfig;
use ApplicationCoreLang\View\Helper\LanguagesSwitcher;
use Zend\Mvc\Application;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\HelperPluginManager;

class LanguagesSwitcherSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return LanguagesSwitcher
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var HelperPluginManager $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();

        /**
         * @var LangConfig  $langConfig
         * @var Application $app
         */
        $langConfig = $serviceLocator->get(LangConfig::class);
        $app = $serviceLocator->get('Application');
        $routeMatch = $app->getMvcEvent()->getRouteMatch();

        return new LanguagesSwitcher($routeMatch, $langConfig);
    }
}