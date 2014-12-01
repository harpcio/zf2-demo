<?php

namespace Module\Auth\Controller\Plugin\SLFactory;

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