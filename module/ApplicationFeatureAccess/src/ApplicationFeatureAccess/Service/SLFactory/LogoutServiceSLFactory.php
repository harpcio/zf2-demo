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

namespace ApplicationFeatureAccess\Service\SLFactory;

use ApplicationFeatureAccess\Service\LogoutService;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LogoutServiceSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return LogoutService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var AuthenticationService $authService
         */
        $authService = $serviceLocator->get(AuthenticationService::class);

        return new LogoutService($authService);
    }
}