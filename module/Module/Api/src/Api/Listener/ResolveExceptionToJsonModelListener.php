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