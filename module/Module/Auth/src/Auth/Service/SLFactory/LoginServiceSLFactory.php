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

namespace Module\Auth\Service\SLFactory;

use Module\Auth\Service\Adapter\DbAdapter;
use Module\Auth\Service\LoginService;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LoginServiceSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return LoginService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var DbAdapter             $authAdapter
         * @var AuthenticationService $authService
         */
        $authAdapter = $serviceLocator->get(DbAdapter::class);
        $authService = $serviceLocator->get(AuthenticationService::class);

        return new LoginService($authService, $authAdapter);
    }
}