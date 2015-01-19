<?php

namespace ApplicationFeatureLibraryBooks\Controller\SLFactory;

use ApplicationFeatureLibraryBooks\Controller\IndexController;
use ApplicationFeatureLibraryBooks\Service\FilterResultsService;
use BusinessLogicLibrary\Pagination\PaginatorInfoFactory;
use BusinessLogicLibrary\QueryFilter\QueryFilter;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerSLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return IndexController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ControllerManager $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();

        /**
         * @var FilterResultsService $service
         * @var QueryFilter          $queryFilter
         * @var PaginatorInfoFactory $paginatorInfoFactory
         */
        $service = $serviceLocator->get(FilterResultsService::class);
        $queryFilter = $serviceLocator->get(QueryFilter::class);
        $paginatorInfoFactory = $serviceLocator->get(PaginatorInfoFactory::class);

        return new IndexController($service, $queryFilter, $paginatorInfoFactory);
    }
}