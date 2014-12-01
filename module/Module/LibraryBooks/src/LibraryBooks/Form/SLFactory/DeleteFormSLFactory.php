<?php

namespace Module\LibraryBooks\Form\SLFactory;

use Module\LibraryBooks\Form\DeleteFormInputFilter;
use Module\LibraryBooks\Form\DeleteForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DeleteFormSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return DeleteForm
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var $filter DeleteFormInputFilter
         */
        $filter = $serviceLocator->get(DeleteFormInputFilter::class);

        $form = new DeleteForm();
        $form->setInputfilter($filter);

        return $form;
    }
}