<?php

namespace Application\Library\Logger\Factory;

use Application\Library\Logger\Manager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LoggerFactory implements FactoryInterface
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
        /** @var \Application\Library\Logger\Manager $loggerManager */
        $loggerManager = $serviceLocator->get(Manager::class);

        return $loggerManager->createErrorInfoLog('app');
    }
}