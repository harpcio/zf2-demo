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

namespace ApplicationCoreAcl\Service\SLFactory;

use ApplicationCoreAcl\Service\AclService;
use ApplicationCoreAcl\Service\AclFactory;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class AclFactorySLFactory implements FactoryInterface
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
         * @var array $modules
         * @var array $config
         */
        $modules = $serviceLocator->get('ApplicationConfig')['modules'];
        $config = $serviceLocator->get('Config')['acl'];

        return new AclFactory($modules, $config);
    }
}