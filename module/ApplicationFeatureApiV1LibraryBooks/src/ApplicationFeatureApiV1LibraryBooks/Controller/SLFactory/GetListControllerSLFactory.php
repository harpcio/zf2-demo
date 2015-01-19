<?php
/**
 * This file is part of Zf2-demo package
 *
 * @author Rafal Ksiazek <harpcio@gmail.com>
 * @copyright Rafal Ksiazek F.H.U. Studioars
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApplicationFeatureApiV1LibraryBooks\Controller\SLFactory;

use BusinessLogicLibrary\Pagination\PaginatorInfoFactory;
use BusinessLogicLibrary\QueryFilter\QueryFilter;
use ApplicationFeatureApiV1LibraryBooks\Controller\GetListController;
use ApplicationFeatureLibraryBooks\Service\FilterResultsService;
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
         * @var FilterResultsService $service
         * @var QueryFilter          $queryFilter
         * @var PaginatorInfoFactory $paginatorInfoFactory
         */
        $service = $serviceLocator->get(FilterResultsService::class);
        $queryFilter = $serviceLocator->get(QueryFilter::class);
        $paginatorInfoFactory = $serviceLocator->get(PaginatorInfoFactory::class);

        return new GetListController($service, $queryFilter, $paginatorInfoFactory);
    }
}