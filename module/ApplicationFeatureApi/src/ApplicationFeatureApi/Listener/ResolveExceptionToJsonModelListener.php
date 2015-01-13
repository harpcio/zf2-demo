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

namespace ApplicationFeatureApi\Listener;

use ApplicationFeatureApi\Exception;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;

class ResolveExceptionToJsonModelListener implements ListenerAggregateInterface
{
    private $listeners = array();

    /**
     * @param MvcEvent $e
     *
     * @return bool|JsonModel
     */
    public function onError(MvcEvent $e)
    {
        if (!($error = $e->getError())) {
            return true;
        }

        $exception = $e->getParam('exception');

        if (!$exception || !($exception instanceof Exception\AbstractException)) {
            return true;
        }

        $e->setParam('exception', null);

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

    /**
     * @inheritdoc
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onError'), 1);
        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER_ERROR, array($this, 'onError'), 1);
    }

    /**
     * @inheritdoc
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
}