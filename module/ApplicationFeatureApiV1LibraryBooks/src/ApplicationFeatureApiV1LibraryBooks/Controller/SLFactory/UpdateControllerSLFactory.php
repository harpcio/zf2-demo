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

use ApplicationFeatureApiV1LibraryBooks\Controller\UpdateController;
use ApplicationFeatureLibraryBooks\Form\CreateFormInputFilter;
use ApplicationFeatureLibraryBooks\Service\CrudService;
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