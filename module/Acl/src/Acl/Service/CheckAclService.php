<?php

namespace Acl\Service;

use BusinessLogic\Users\Entity\UserEntity;
use Module\Api\Controller\AbstractApiActionController;
use Module\Api\Exception\UnauthorizedException;
use Zend\Authentication\AuthenticationService;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Acl\Acl;
use Zend\Stdlib\ResponseInterface;
use Zend\View\Helper\Navigation;

class CheckAclService
{
    /**
     * @var AuthenticationService
     */
    private $authService;

    /**
     * @var Acl
     */
    private $acl;

    /**
     * @param AuthenticationService $authService
     * @param Acl                   $acl
     */
    public function __construct(AuthenticationService $authService, Acl $acl)
    {
        $this->authService = $authService;
        $this->acl = $acl;
    }

    /**
     * Main method to check authorization
     *
     * @param MvcEvent $e
     *
     * @throws UnauthorizedException
     * @return ResponseInterface|bool
     */
    public function checkAccess(MvcEvent $e)
    {
        /** @var UserEntity $identity */
        $identity = $this->authService->getIdentity();
        $role = $identity ? $identity->getRole() : UserEntity::ROLE_GUEST;

        list($moduleName, $controllerName, $actionName) = $this->getModuleAndControllerAndAction($e);


        $response = true;
        if (!$this->acl->isAllowed($role, $moduleName, $controllerName . ':' . $actionName)) {
            if ($e->getTarget() instanceof AbstractApiActionController) {
                throw new UnauthorizedException();
            }
            $router = $e->getRouter();
            $url = $router->assemble(['controller' => 'login'], ['name' => 'auth/default']);

            if ($role !== UserEntity::ROLE_GUEST) {
                $url = $router->assemble(['controller' => 'no-access'], ['name' => 'auth/default']);
            }

            /** @var Response $response */
            $response = $e->getResponse();
            $response->setStatusCode(302);
            $response->getHeaders()->addHeaderLine('Location', $url);
            $e->stopPropagation();
        }

        $e->getViewModel()->setVariable('acl', $this->acl);

        return $response;
    }

    protected function getModuleAndControllerAndAction(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();

        $controller = $e->getTarget();
        $controllerClass = get_class($controller);

        $moduleName = substr($controllerClass, 0, strrpos($controllerClass, '\\'));
        $moduleName = strtolower(substr($moduleName, 0, strrpos($moduleName, '\\')));

        $controllerName = substr($controllerClass, strrpos($controllerClass, '\\') + 1);
        $controllerName = strtolower(str_replace('Controller', '', $controllerName));

        $actionName = strtolower($routeMatch->getParam('action', 'not-found'));

        return [$moduleName, $controllerName, $actionName];
    }

}
