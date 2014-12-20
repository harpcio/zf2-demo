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

namespace Module\Auth\Service\Storage\SLFactory;

use Module\Auth\Service\Storage\DbStorage;
use BusinessLogic\Users\Repository\UsersRepository;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DbStorageSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return \Module\Auth\Service\Storage\DbStorage
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var UsersRepository $userRepository */
        $userRepository = $serviceLocator->get(UsersRepository::class);

        return new DbStorage($userRepository);
    }
}