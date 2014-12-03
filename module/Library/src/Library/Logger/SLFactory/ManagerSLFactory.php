<?php

namespace Library\Logger\SLFactory;

use Library\Logger\Factory\ComponentsFactory;
use Library\Logger\Manager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ManagerSLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return Manager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ComponentsFactory $loggerFactory */
        $loggerFactory = $serviceLocator->get(ComponentsFactory::class);

        return new Manager($loggerFactory);
    }
}