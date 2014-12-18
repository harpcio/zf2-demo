<?php

namespace Application\Listener\Lang\SLFactory;

use Application\Listener\Lang\LangRedirector;
use Application\Model\LangConfig;
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