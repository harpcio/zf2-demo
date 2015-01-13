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

namespace ApplicationCoreLang\Model\SLFactory;

use ApplicationCoreLang\Model\LangConfig;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class LangConfigSLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return LangConfig
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var array $config
         */
        $config = $serviceLocator->get('Config');

        return new LangConfig($config);
    }
}