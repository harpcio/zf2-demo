<?php

namespace Acl\Service\Listener\SLFactory;

use Acl\Service\AclService;
use Acl\Service\Listener\CheckAccessListener;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class CheckAccessListenerSLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return AclService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var AclService $aclService
         */
        $aclService = $serviceLocator->get(AclService::class);

        return new CheckAccessListener($aclService);
    }
}