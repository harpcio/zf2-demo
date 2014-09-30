<?php

namespace Library\Controller\Book\Factory;

use Library\Controller\Book\DeleteController;
use Library\Form\DeleteForm;
use Library\Service\Book\CrudService;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DeleteControllerFactory implements FactoryInterface
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