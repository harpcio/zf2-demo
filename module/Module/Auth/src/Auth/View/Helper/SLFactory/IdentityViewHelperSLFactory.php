<?php

namespace Module\Auth\View\Helper\SLFactory;

use Module\Auth\Service\Storage\DbStorage;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\HelperPluginManager;
use Zend\View\Helper\Identity;

class IdentityViewHelperSLFactory implements FactoryInterface
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
        /** @var HelperPluginManager $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();

        /** @var DbStorage $storage */
        $storage = $serviceLocator->get(DbStorage::class);
        $authentication = new AuthenticationService($storage);

        $identity = new Identity();
        $identity->setAuthenticationService($authentication);

        return $identity;
    }
}