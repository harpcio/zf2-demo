<?php

namespace BusinessLogic\Books;

use Zend\Loader\ClassMapAutoloader;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
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
        return array(
            ClassMapAutoloader::class => [
                __DIR__ . '/autoload_classmap.php',
            ],
            StandardAutoloader::class => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/Books',
                    __NAMESPACE__ . 'Test' => __DIR__ . '/test/BooksTest'
                ),
            ),
        );
    }
}
