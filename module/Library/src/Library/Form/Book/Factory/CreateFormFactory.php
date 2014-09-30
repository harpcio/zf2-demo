<?php

namespace Library\Form\Book\Factory;

use Library\Form\Book\CreateFormInputFilter;
use Library\Form\Book\CreateForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CreateFormFactory implements FactoryInterface
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