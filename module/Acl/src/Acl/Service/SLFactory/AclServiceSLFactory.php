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

namespace Acl\Service\SLFactory;

use Acl\Model\NamesResolver;
use Acl\Service\AclService;
use Acl\Service\AclFactory;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class AclServiceSLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return \Acl\Service\AclService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var AclFactory            $aclFactory
         * @var AuthenticationService $authenticationService
         */
        $aclFactory = $serviceLocator->get(AclFactory::class);
        $authenticationService = $serviceLocator->get(AuthenticationService::class);
        $namesResolver = $serviceLocator->get(NamesResolver::class);

        $acl = $aclFactory->create();

        return new AclService($authenticationService, $acl, $namesResolver);
    }
}