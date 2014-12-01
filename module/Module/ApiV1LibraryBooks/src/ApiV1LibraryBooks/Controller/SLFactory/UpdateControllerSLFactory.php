<?php

namespace Module\ApiV1LibraryBooks\Controller\SLFactory;

use Module\ApiV1LibraryBooks\Controller\UpdateController;
use Module\LibraryBooks\Form\CreateFormInputFilter;
use Module\LibraryBooks\Service\CrudService;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UpdateControllerSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return UpdateController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ControllerManager $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();
        /**
         * @var $service CrudService
         * @var $filter  CreateFormInputFilter
         */
        $filter = $serviceLocator->get(CreateFormInputFilter::class);
        $service = $serviceLocator->get(CrudService::class);

        return new UpdateController($filter, $service);
    }
}