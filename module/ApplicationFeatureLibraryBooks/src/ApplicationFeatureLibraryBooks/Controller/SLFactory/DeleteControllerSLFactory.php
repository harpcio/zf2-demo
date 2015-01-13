<?php

namespace ApplicationFeatureLibraryBooks\Controller\SLFactory;

use ApplicationFeatureLibraryBooks\Controller\DeleteController;
use ApplicationFeatureLibraryBooks\Form\DeleteForm;
use ApplicationFeatureLibraryBooks\Service\CrudService;
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
         * @var $form    DeleteForm
         * @var $service CrudService
         */
        $form = $serviceLocator->get(DeleteForm::class);
        $service = $serviceLocator->get(CrudService::class);

        return new DeleteController($form, $service);
    }
}