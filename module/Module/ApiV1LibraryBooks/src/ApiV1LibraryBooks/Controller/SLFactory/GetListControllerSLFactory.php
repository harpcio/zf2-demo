<?php

namespace Module\ApiV1LibraryBooks\Controller\SLFactory;

use Library\QueryFilter\QueryFilter;
use Module\ApiV1LibraryBooks\Controller\GetListController;
use Module\LibraryBooks\Service\FilterResultsService;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GetListControllerSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return GetListController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ControllerManager $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();

        /**
         * @var $service     FilterResultsService
         * @var $queryFilter QueryFilter
         * @var $em          EntityManager
         */
        $service = $serviceLocator->get(FilterResultsService::class);
        $queryFilter = $serviceLocator->get(QueryFilter::class);

        return new GetListController($service, $queryFilter);
    }
}