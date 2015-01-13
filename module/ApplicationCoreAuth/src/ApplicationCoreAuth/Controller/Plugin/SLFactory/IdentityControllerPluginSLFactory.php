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

namespace ApplicationCoreAuth\Controller\Plugin\SLFactory;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\PluginManager;
use Zend\Mvc\Controller\Plugin\Identity;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IdentityControllerPluginSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return Identity
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var PluginManager $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();
        $authentication = $serviceLocator->get(AuthenticationService::class);

        $identity = new Identity();
        $identity->setAuthenticationService($authentication);

        return $identity;
    }
}