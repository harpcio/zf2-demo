<?php

namespace Api\Controller\V1\Library\Book\Factory;

use Api\Controller\V1\Library\Book\GetController;
use Library\Service\Book\CrudService;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GetControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return GetController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ControllerManager $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();

        /**
         * @var $service CrudService
         */
        $service = $serviceLocator->get(CrudService::class);

        return new GetController($service);
    }
}