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

namespace ApplicationFeatureAccess;

use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use Zend\Loader\StandardAutoloader;

class Module implements DependencyIndicatorInterface
{
    public function getModuleDependencies()
    {
        return ['BusinessLogicDomainUsers'];
    }

    public function getConfig()
    {
        return array_merge(
            include __DIR__ . '/config/acl.config.php',
            include __DIR__ . '/config/module.config.php',
            include __DIR__ . '/config/controller.config.php',
            include __DIR__ . '/config/router.config.php',
            include __DIR__ . '/config/service.config.php',
            include __DIR__ . '/config/view.config.php'
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            StandardAutoloader::class => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    __NAMESPACE__ . 'Test' => __DIR__ . '/test/' . __NAMESPACE__ . 'Test',
                ),
            ),
        );
    }
}
