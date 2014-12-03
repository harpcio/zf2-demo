<?php

namespace Library\Logger\SLFactory;

use Library\Logger\Manager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LoggerSLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Library\Logger\Manager $loggerManager */
        $loggerManager = $serviceLocator->get(Manager::class);

        return $loggerManager->createErrorInfoLog('app');
    }
}