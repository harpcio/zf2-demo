<?php

namespace Module\Api\Listener;

use Module\Api\Exception;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;

class ResolveExceptionToJsonModelListener
{
    /**
     * @param MvcEvent $e
     *
     * @return bool|JsonModel
     */
    public function __invoke(MvcEvent $e)
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

        $model = new JsonModel($errorJson);
        $e->setResult($model);

        return $model;
    }
}