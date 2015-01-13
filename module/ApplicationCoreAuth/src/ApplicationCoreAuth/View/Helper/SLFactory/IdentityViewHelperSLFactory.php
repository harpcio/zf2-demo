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

namespace ApplicationCoreAuth\View\Helper\SLFactory;

use ApplicationCoreAuth\Service\Storage\DbStorage;
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