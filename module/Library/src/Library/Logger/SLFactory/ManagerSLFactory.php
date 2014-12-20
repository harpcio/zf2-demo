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

namespace Library\Logger\SLFactory;

use Library\Logger\Factory\ComponentsFactory;
use Library\Logger\Manager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ManagerSLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return Manager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ComponentsFactory $loggerFactory */
        $loggerFactory = $serviceLocator->get(ComponentsFactory::class);

        return new Manager($loggerFactory);
    }
}