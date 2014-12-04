<?php

namespace Module\LibraryBooks;

use Zend\Loader\ClassMapAutoloader;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Loader\StandardAutoloader;

class Module implements DependencyIndicatorInterface
{
    public function getModuleDependencies()
    {
        return ['Module\\Library', 'BusinessLogic\\Books'];
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
            include __DIR__ . '/config/acl.config.php',
            include __DIR__ . '/config/module.config.php',
            include __DIR__ . '/config/controller.config.php',
            include __DIR__ . '/config/router.config.php',
            include __DIR__ . '/config/service.config.php',
            include __DIR__ . '/config/view.config.php',
            include __DIR__ . '/config/navigation.config.php'
        );
    }

    public function getAutoloaderConfig()
    {
        return [
            ClassMapAutoloader::class => [
                __DIR__ . '/autoload_classmap.php',
            ],
            StandardAutoloader::class => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/LibraryBooks',
                    __NAMESPACE__ . 'Test' => __DIR__ . '/test/LibraryBooksTest'
                ],
            ],
        ];
    }
}
