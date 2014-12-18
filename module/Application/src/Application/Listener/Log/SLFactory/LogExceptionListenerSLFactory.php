<?php

namespace Application\Listener\Log\SLFactory;

use Application\Listener\Log\LogExceptionListener;
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
     * @return \Application\Listener\Log\LogExceptionListener
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