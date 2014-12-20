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

namespace Application\Listener\Log\SLFactory;

use Application\Listener\Log\LogExceptionListener;
use Zend\Log\LoggerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class LogExceptionListenerSLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return \Application\Listener\Log\LogExceptionListener
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var LoggerInterface $logger
         */
        $logger = $serviceLocator->get('Logger');

        return new LogExceptionListener($logger);
    }
}