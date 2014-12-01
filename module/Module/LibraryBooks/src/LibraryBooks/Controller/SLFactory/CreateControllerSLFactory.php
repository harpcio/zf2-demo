<?php

namespace Module\LibraryBooks\Controller\SLFactory;

use Module\LibraryBooks\Controller\CreateController;
use Module\LibraryBooks\Form\CreateForm;
use Module\LibraryBooks\Service\CrudService;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CreateControllerSLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return CreateController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ControllerManager $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();

        /**
         * @var $form    CreateForm
         * @var $service CrudService
         */
        $form = $serviceLocator->get(CreateForm::class);
        $service = $serviceLocator->get(CrudService::class);

        return new CreateController($form, $service);
    }
}