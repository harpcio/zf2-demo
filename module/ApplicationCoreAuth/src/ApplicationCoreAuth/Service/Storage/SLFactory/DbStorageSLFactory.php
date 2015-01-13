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

namespace ApplicationCoreAuth\Service\Storage\SLFactory;

use ApplicationCoreAuth\Service\Storage\DbStorage;
use BusinessLogicDomainUsers\Repository\UsersRepository;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DbStorageSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return DbStorage
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var UsersRepository $userRepository */
        $userRepository = $serviceLocator->get(UsersRepository::class);

        return new DbStorage($userRepository);
    }
}