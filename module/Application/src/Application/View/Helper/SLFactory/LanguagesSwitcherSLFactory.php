<?php

namespace Application\View\Helper\SLFactory;

use Application\Model\LangConfig;
use Application\View\Helper\LanguagesSwitcher;
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