<?php

namespace Acl\Service;

use Acl\Model\NamesResolver;
use BusinessLogic\Users\Entity\UserEntity;
use Module\Api\Controller\AbstractApiActionController;
use Module\Api\Exception\UnauthorizedException;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Acl\AclInterface;
use Zend\Stdlib\ResponseInterface;
use Zend\View\Helper\Navigation;

class AclService
{
    /**
     * @var AuthenticationServiceInterface
     */
    private $authService;

    /**
     * @var AclInterface
     */
    private $acl;

    /**
     * @var NamesResolver
     */
    private $namesResolver;

    /**
     * @param AuthenticationServiceInterface $authService
     * @param AclInterface                   $acl
     * @param NamesResolver                  $namesResolver
     */
    public function __construct(
        AuthenticationServiceInterface $authService,
        AclInterface $acl,
        NamesResolver $namesResolver
    ) {
        $this->authService = $authService;
        $this->acl = $acl;
        $this->namesResolver = $namesResolver;
    }

    /**
     * Main method to check authorization
     *
     * @param MvcEvent $e
     *
     * @throws UnauthorizedException
     * @return ResponseInterface
     */
    public function checkAccess(MvcEvent $e)
    {
        /** @var Response $response */
        $response = $e->getResponse();

        /** @var UserEntity $identity */
        $identity = $this->authService->getIdentity();
        $role = $identity ? $identity->getRole() : UserEntity::ROLE_GUEST;

        list($moduleName, $controllerName, $actionName) = $this->namesResolver->resolve($e);

        if ($this->acl->isAllowed($role, $moduleName, $controllerName . ':' . $actionName)) {
            $e->getViewModel()->setVariable('acl', $this->acl);

            return $response;
        }

        if ($e->getTarget() instanceof AbstractApiActionController) {
            throw new UnauthorizedException();
        }

        $router = $e->getRouter();
        $url = $router->assemble(['controller' => 'login'], ['name' => 'auth/default']);

        if ($role !== UserEntity::ROLE_GUEST) {
            $url = $router->assemble(['controller' => 'no-access'], ['name' => 'auth/default']);
        }

        $response->setStatusCode(302);
        $response->getHeaders()->clearHeaders();
        $response->getHeaders()->addHeaderLine('Location', $url);

        $e->stopPropagation();

        return $response;
    }
}
