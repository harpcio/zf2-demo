<?php

namespace Module\LibraryBooks\Form\SLFactory;

use Module\LibraryBooks\Form\CreateFormInputFilter;
use Module\LibraryBooks\Form\CreateForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CreateFormSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return CreateForm
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var $filter CreateFormInputFilter
         */
        $filter = $serviceLocator->get(CreateFormInputFilter::class);

        $form = new CreateForm();
        $form->setInputfilter($filter);

        return $form;
    }
}