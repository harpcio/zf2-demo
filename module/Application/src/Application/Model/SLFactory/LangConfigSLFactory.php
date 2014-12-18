<?php

namespace Application\Model\SLFactory;

use Application\Model\LangConfig;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class LangConfigSLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return LangConfig
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var array $config
         */
        $config = $serviceLocator->get('Config');

        return new LangConfig($config);
    }
}