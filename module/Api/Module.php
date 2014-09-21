<?php

namespace Api;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Loader\StandardAutoloader;
use Zend\View\Model\JsonModel;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'onDispatchError'], 0);
        $eventManager->attach(MvcEvent::EVENT_RENDER_ERROR, [$this, 'onRenderError'], 0);
    }

    public function onDispatchError(MvcEvent $e)
    {
        return $this->getJsonModelError($e);
    }

    public function onRenderError(MvcEvent $e)
    {
        return $this->getJsonModelError($e);
    }

    public function getJsonModelError(MvcEvent $e)
    {
        $error = $e->getError();
        if (!$error) {
            return true;
        }

        $exception = $e->getParam('exception');

        if (!$error || !($exception instanceof Exception\AbstractException)) {
            return true;
        }

        /** @var \Zend\Http\Response $response */
        $response = $e->getResponse();
        $response->setStatusCode($exception->getCode());

        $errorJson = [
            'errorCode' => $exception->getCode(),
            'message'   => $exception->getMessage()
        ];

        if (DEVELOPMENT_ENV) {
            $errorJson['exception'] = [
                'class'      => get_class($exception),
                'file'       => $exception->getFile(),
                'line'       => $exception->getLine(),
                'message'    => $exception->getMessage(),
                'stacktrace' => $exception->getTraceAsString()
            ];
        }

        $model = new JsonModel($errorJson);
        $e->setResult($model);

        return $model;
    }

    public function getConfig()
    {
        return array_merge(
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
                ),
            ),
        );
    }
}
