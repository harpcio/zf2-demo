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

namespace BusinessLogicDomainUsers\Repository\SLFactory;

use Doctrine\ORM\EntityManager;
use BusinessLogicDomainUsers\Entity\UserEntity;
use BusinessLogicDomainUsers\Repository\UsersRepository;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UsersRepositorySLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return UsersRepository
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var $em              EntityManager
         * @var $usersRepository UsersRepository
         */
        $em = $serviceLocator->get(EntityManager::class);
        $usersRepository = $em->getRepository(UserEntity::class);

        return $usersRepository;
    }
}