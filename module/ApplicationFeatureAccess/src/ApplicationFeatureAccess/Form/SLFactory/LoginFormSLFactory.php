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

namespace ApplicationFeatureAccess\Form\SLFactory;

use ApplicationFeatureAccess\Form\LoginForm;
use ApplicationFeatureAccess\Form\LoginFormInputFilter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LoginFormSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return LoginForm
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var $filter LoginFormInputFilter
         */
        $filter = $serviceLocator->get(LoginFormInputFilter::class);

        $form = new LoginForm();
        $form->setInputfilter($filter);

        return $form;
    }
}