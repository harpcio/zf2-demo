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