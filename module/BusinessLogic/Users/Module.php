<?php

namespace BusinessLogic\Users;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Loader\ClassMapAutoloader;
use Zend\Loader\StandardAutoloader;

class Module
{
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
            include __DIR__ . '/config/service.config.php'
        );
    }

    public function getAutoloaderConfig()
    {
        return [
//            ClassMapAutoloader::class => [
//                __DIR__ . '/autoload_classmap.php',
//            ],
            StandardAutoloader::class => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . basename(__NAMESPACE__),
                    __NAMESPACE__ . 'Test' => __DIR__ . '/test/' . basename(__NAMESPACE__) . 'Test'
                ],
            ],
        ];
    }
}
