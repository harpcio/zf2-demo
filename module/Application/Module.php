<?php

namespace Application;

use Application\Listener\Lang\LangListener;
use Application\Listener\Log\LogExceptionListener;
use Zend\Mvc\Application;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Loader\StandardAutoloader;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $this->setDefaultLocaleInWhichTheApplicationIsWritten();

        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $sharedManager = $eventManager->getSharedManager();
        $sm = $e->getApplication()->getServiceManager();

        $logExceptionListener = $sm->get(LogExceptionListener::class);
        $sharedManager->attach(
            Application::class,
            MvcEvent::EVENT_DISPATCH_ERROR,
            $logExceptionListener
        );

        $langListener = $sm->get(LangListener::class);
        $eventManager->attach(
            MvcEvent::EVENT_ROUTE,
            $langListener
        );
    }

    /**
     * If you written your application in other language than english,
     * please change this locale to your default character language
     */
    private function setDefaultLocaleInWhichTheApplicationIsWritten()
    {
        \Locale::setDefault(APPLICATION_LOCALE);
    }

    public function getConfig()
    {
        return array_merge(
            include __DIR__ . '/config/module.config.php',
            include __DIR__ . '/config/controller.config.php',
            include __DIR__ . '/config/router.config.php',
            include __DIR__ . '/config/console-router.config.php',
            include __DIR__ . '/config/service.config.php',
            include __DIR__ . '/config/view.config.php',
            include __DIR__ . '/config/navigation.config.php'
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            StandardAutoloader::class => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    __NAMESPACE__ . 'Test' => __DIR__ . '/test/' . __NAMESPACE__ . 'Test'
                ),
            ),
        );
    }

}
