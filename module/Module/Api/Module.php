<?php

namespace Module\Api;

use Module\Api\Exception;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Loader\StandardAutoloader;
use Zend\View\Model\JsonModel;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'getJsonModelError'], 0);
        $eventManager->attach(MvcEvent::EVENT_RENDER_ERROR, [$this, 'getJsonModelError'], 0);
    }

    public function getJsonModelError(MvcEvent $e)
    {
        if (!($error = $e->getError())) {
            return true;
        }

        $exception = $e->getParam('exception');

        if (!$exception || !($exception instanceof Exception\AbstractException)) {
            return true;
        }

        /** @var \Zend\Http\Response $response */
        $response = $e->getResponse();
        $response->setStatusCode($exception->getCode());

        $errorJson = [
            'errorCode' => $exception->getCode(),
            'message' => $exception->getMessage()
        ];

        if (DEVELOPMENT_ENV) {
            $errorJson['exception'] = [
                'class' => get_class($exception),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'message' => $exception->getMessage(),
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
            include __DIR__ . '/config/controller.config.php',
            include __DIR__ . '/config/module.config.php',
            include __DIR__ . '/config/router.config.php'
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            StandardAutoloader::class => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/Api',
                    __NAMESPACE__ . 'Test' => __DIR__ . '/test/ApiTest'
                ),
            ),
        );
    }
}
