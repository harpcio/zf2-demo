<?php

namespace Application\Service\Listener\SLFactory;

use Application\Service\Listener\LogExceptionListener;
use Zend\Log\LoggerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class LogExceptionListenerSLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return LogExceptionListener
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var LoggerInterface $logger
         */
        $logger = $serviceLocator->get('Logger');

        return new LogExceptionListener($logger);
    }
}