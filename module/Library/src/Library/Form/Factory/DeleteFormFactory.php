<?php

namespace Library\Form\Factory;

use Library\Form\DeleteFormInputFilter;
use Library\Form\DeleteForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DeleteFormFactory implements FactoryInterface
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