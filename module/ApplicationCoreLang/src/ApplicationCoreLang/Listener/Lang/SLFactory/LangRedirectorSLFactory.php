<?php

namespace ApplicationCoreLang\Listener\Lang\SLFactory;

use ApplicationCoreLang\Listener\Lang\LangRedirector;
use ApplicationCoreLang\Model\LangConfig;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class LangRedirectorSLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return LangRedirector
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var LangConfig $langConfig
         */
        $langConfig = $serviceLocator->get(LangConfig::class);

        return new LangRedirector($langConfig);
    }
}