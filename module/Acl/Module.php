<?php

namespace Acl;

use Acl\Service\AclService;
use Acl\Service\Listener\CheckAccessListener;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Loader\StandardAutoloader;

class Module implements DependencyIndicatorInterface
{
    public function getModuleDependencies()
    {
        return ['BusinessLogic\\Users', 'Module\\Auth', 'Module\\Api'];
    }

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager->attach(MvcEvent::EVENT_ROUTE, [$this, 'checkAccess'], 1);
    }

    public function checkAccess(MvcEvent $e)
    {
        $application = $e->getApplication();
        $sm = $application->getServiceManager();
        $sharedManager = $application->getEventManager()->getSharedManager();

        $router = $e->getRouter();
        $request = $e->getRequest();

        $matchedRoute = $router->match($request);
        if (null !== $matchedRoute) {
            $checkAccessListener = $sm->get(CheckAccessListener::class);

            $sharedManager->attach(
                AbstractActionController::class,
                MvcEvent::EVENT_DISPATCH,
                $checkAccessListener,
                2
            );
        }
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
                    __NAMESPACE__ . 'Test' => __DIR__ . '/test/' . __NAMESPACE__ . 'Test'
                ),
            ),
        );
    }
}
