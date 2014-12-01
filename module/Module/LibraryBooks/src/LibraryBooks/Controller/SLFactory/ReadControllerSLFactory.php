<?php

namespace Module\LibraryBooks\Controller\SLFactory;

use Module\LibraryBooks\Controller\ReadController;
use Module\LibraryBooks\Service\CrudService;
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