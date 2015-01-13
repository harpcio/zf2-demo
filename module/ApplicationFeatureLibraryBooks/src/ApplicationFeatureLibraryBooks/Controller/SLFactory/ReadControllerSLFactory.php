<?php

namespace ApplicationFeatureLibraryBooks\Controller\SLFactory;

use ApplicationFeatureLibraryBooks\Controller\ReadController;
use ApplicationFeatureLibraryBooks\Service\CrudService;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ReadControllerSLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return ReadController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ControllerManager $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();

        /**
         * @var $service CrudService
         */
        $service = $serviceLocator->get(CrudService::class);

        return new ReadController($service);
    }
}