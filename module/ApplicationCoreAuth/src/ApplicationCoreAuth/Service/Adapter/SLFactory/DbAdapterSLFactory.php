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

namespace ApplicationCoreAuth\Service\Adapter\SLFactory;

use ApplicationCoreAuth\Service\Adapter\DbAdapter;
use BusinessLogicDomainUsers\Repository\UsersRepository;
use Zend\Crypt\Password\Bcrypt;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DbAdapterSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return DbAdapter
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var UsersRepository $userRepository */
        $userRepository = $serviceLocator->get(UsersRepository::class);
        $passwordCrypt = new Bcrypt();

        return new DbAdapter($userRepository, $passwordCrypt);
    }
}