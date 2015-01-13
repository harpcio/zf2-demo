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

namespace ApplicationCoreAcl\Model;

use Zend\Mvc\MvcEvent;

class NamesResolver
{
    public function resolve(MvcEvent $event)
    {
        $routeMatch = $event->getRouteMatch();

        $controller = $event->getTarget();
        $controllerClass = get_class($controller);

        $moduleName = substr($controllerClass, 0, strrpos($controllerClass, '\\'));
        $moduleName = strtolower(substr($moduleName, 0, strrpos($moduleName, '\\')));

        $controllerName = substr($controllerClass, strrpos($controllerClass, '\\') + 1);
        $controllerName = strtolower(str_replace('Controller', '', $controllerName));

        $actionName = strtolower($routeMatch->getParam('action', 'not-found'));

        return [$moduleName, $controllerName, $actionName];
    }
}