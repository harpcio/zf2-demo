<?php

namespace Acl\Service\SLFactory;

use Acl\Service\CheckAclService;
use Acl\Service\AclFactory;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class CheckAclServiceSLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return \Acl\Service\CheckAclService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var AclFactory            $aclFactory
         * @var AuthenticationService $authenticationService
         */
        $aclFactory = $serviceLocator->get(AclFactory::class);
        $authenticationService = $serviceLocator->get(AuthenticationService::class);

        $acl = $aclFactory->create();

        return new CheckAclService($authenticationService, $acl);
    }
}