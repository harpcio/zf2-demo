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

namespace Module\Api\Controller;

use Module\Api\Exception;
use Zend\EventManager\EventManagerInterface;
use Zend\Http\Request;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Exception as MvcException;
use Zend\Stdlib\Parameters;

abstract class AbstractRestfulJsonController extends AbstractRestfulController
{
    /**
     * @return array
     */
    abstract protected function getCollectionOptions();

    /**
     * @return array
     */
    abstract protected function getResourceOptions();

    public function options()
    {
        /** @var \Zend\Http\Response $response */
        $response = $this->getResponse();

        $response->getHeaders()
            ->addHeaderLine('Allow', implode(',', $this->getOptions()));

        return $response;
    }

    protected function getOptions()
    {
        if ($this->params()->fromRoute('id', false)) {
            return $this->getResourceOptions();
        }

        return $this->getCollectionOptions();
    }

    public function checkOptions(MvcEvent $e)
    {
        /** @var \Zend\Http\Request $request */
        $request = $e->getRequest();
        $method = strtoupper($request->getMethod());
        $options = array_map('strtoupper', $this->getOptions());

        if (!in_array($method, $options)) {
            throw new Exception\MethodNotAllowedException();
        }
    }

    public function setEventManager(EventManagerInterface $events)
    {
        parent::setEventManager($events);

        $this->events->attach('dispatch', [$this, 'checkOptions'], 10);
    }

    public function onDispatch(MvcEvent $e)
    {
        /**
         * @var Request  $request
         * @var Response $response
         */
        $request = $e->getRequest();
        $response = $e->getResponse();
        $method = strtoupper($request->getMethod());

        $routeMatch = $e->getRouteMatch();
        $controllerName = $routeMatch->getParam('controller');
        $namespace = substr($controllerName, 0, strrpos($controllerName, '\\'));

        // Was an "action" requested?
        $action = $routeMatch->getParam('action', false);
        if ($action) {
            // Handle arbitrary methods, ending in Action
            $method = static::getMethodFromAction($action);
            if (!method_exists($this, $method)) {
                $method = 'notFoundAction';
            }
            $return = $this->$method();
            $e->setResult($return);
            return $return;
        }

        $controller = null;
        $return = null;

        switch ($method) {
            case Request::METHOD_DELETE:
                $id = $this->getIdentifier($routeMatch, $request);
                if ($id !== false) {
                    $controller = static::prepareControllerName($namespace, 'delete');
                    $return = $this->reDispatch($controller, ['id' => $id]);
                    break;
                }

                $controller = static::prepareControllerName($namespace, 'deleteList');
                $return = $this->reDispatch($controller);
                break;

            case Request::METHOD_GET:
                $id = $this->getIdentifier($routeMatch, $request);

                if ($id !== false) {
                    $controller = static::prepareControllerName($namespace, 'get');
                    $return = $this->reDispatch($controller, ['id' => $id]);
                    break;
                }
                $controller = static::prepareControllerName($namespace, 'getList');
                $return = $this->reDispatch($controller);
                break;

            case Request::METHOD_HEAD:
                $id = $this->getIdentifier($routeMatch, $request);
                if ($id === false) {
                    $id = null;
                }
                $controller = static::prepareControllerName($namespace, 'head');
                $this->reDispatch($controller, ['id' => $id]);
                $response->setContent('');
                $return = $response;
                break;

            case Request::METHOD_OPTIONS:
                $this->options();
                $return = $e->getResponse();
                break;

            case Request::METHOD_PATCH:
                $id = $this->getIdentifier($routeMatch, $request);
                $data = $this->processBodyContent($request);
                $request->setPost(new Parameters($data));

                if ($id !== false) {
                    $controller = static::prepareControllerName($namespace, 'patch');
                    $return = $this->reDispatch($controller, ['id' => $id]);
                    break;
                }

                // TODO: This try-catch should be removed in the future, but it
                // will create a BC break for pre-2.2.0 apps that expect a 405
                // instead of going to patchList
                try {
                    $controller = static::prepareControllerName($namespace, 'patchList');
                    $return = $this->reDispatch($controller);
                } catch (MvcException\RuntimeException $ex) {
                    $response->setStatusCode(405);
                    return $response;
                }
                break;

            case Request::METHOD_POST:
                $controller = static::prepareControllerName($namespace, 'create');
                $data = $this->preparePostOrJsonData($request);
                $request->setPost(new Parameters($data));
                $return = $this->reDispatch($controller);
                break;

            case Request::METHOD_PUT:
                $id = $this->getIdentifier($routeMatch, $request);
                $data = $this->processBodyContent($request);
                $request->setPost(new Parameters($data));

                if ($id !== false) {
                    $controller = static::prepareControllerName($namespace, 'update');
                    $return = $this->reDispatch($controller, ['id' => $id]);
                    break;
                }

                $controller = static::prepareControllerName($namespace, 'replaceList');
                $return = $this->reDispatch($controller);
                break;
            default:
                $response->setStatusCode(405);
                return $response;
                break;
        }

        $routeMatch->setParam('action', 'index');
        $routeMatch->setParam('controller', $controller);
        $e->setResult($return);
        return $return;
    }

    /**
     * @param string $controller
     * @param array  $params
     *
     * @return mixed
     * @throws Exception\MethodNotAllowedException
     */
    protected function reDispatch($controller, array $params = [])
    {
        $params['action'] = 'index';

        if (!class_exists($controller . 'Controller')) {
            throw new Exception\MethodNotAllowedException();
        }

        return $this->forward()->dispatch($controller, $params);
    }

    /**
     * Process post data and call create
     *
     * @param Request $request
     *
     * @return array
     */
    public function preparePostOrJsonData(Request $request)
    {
        if ($this->requestHasContentType($request, self::CONTENT_TYPE_JSON)) {
            $data = Json::decode($request->getContent(), $this->jsonDecodeType);
        } else {
            $data = $request->getPost()->toArray();
        }

        return $data;
    }

    /**
     * @param string $namespace
     * @param string $controller
     *
     * @return string
     */
    public static function prepareControllerName($namespace, $controller)
    {
        $controller = str_replace(array('.', '-', '_'), ' ', $controller);
        $controller = ucwords($controller);
        $controller = str_replace(' ', '', $controller);

        return $namespace . '\\' . $controller;
    }
}