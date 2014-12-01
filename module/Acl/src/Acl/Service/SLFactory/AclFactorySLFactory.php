<?php

namespace Acl\Service\SLFactory;

use Acl\Service\CheckAclService;
use Acl\Service\AclFactory;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class AclFactorySLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return CheckAclService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var array $modules
         * @var array $config
         */
        $modules = $serviceLocator->get('ApplicationConfig')['modules'];
        $config = $serviceLocator->get('Config')['acl'];

        return new AclFactory($modules, $config);
    }
}