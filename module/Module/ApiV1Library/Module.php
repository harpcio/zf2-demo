<?php

namespace Module\ApiV1Library;

use Module\Api\Exception;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Loader\StandardAutoloader;

class Module implements DependencyIndicatorInterface
{
    public function getModuleDependencies()
    {
        return ['Module\\Api'];
    }

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return array_merge(
            include __DIR__ . '/config/module.config.php',
            include __DIR__ . '/config/router.config.php'
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            StandardAutoloader::class => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/ApiV1Library',
                    __NAMESPACE__ . 'Test' => __DIR__ . '/test/ApiV1LibraryTest'
                ),
            ),
        );
    }
}
