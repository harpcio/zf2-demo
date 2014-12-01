<?php

namespace Module\ApiV1LibraryBooks\Controller\SLFactory;

use Module\ApiV1LibraryBooks\Controller\DeleteController;
use Module\LibraryBooks\Service\CrudService;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DeleteControllerSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return DeleteController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ControllerManager $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();

        /**
         * @var $service CrudService
         */
        $service = $serviceLocator->get(CrudService::class);

        return new DeleteController($service);
    }
}