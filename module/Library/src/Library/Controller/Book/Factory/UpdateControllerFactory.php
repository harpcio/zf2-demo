<?php

namespace Library\Controller\Book\Factory;

use Library\Controller\Book\UpdateController;
use Library\Form\Book\CreateForm;
use Library\Service\Book\CrudService;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UpdateControllerFactory implements FactoryInterface
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
         * @var $form    CreateForm
         * @var $service CrudService
         */
        $form = $serviceLocator->get(CreateForm::class);
        $service = $serviceLocator->get(CrudService::class);

        return new UpdateController($form, $service);
    }
}