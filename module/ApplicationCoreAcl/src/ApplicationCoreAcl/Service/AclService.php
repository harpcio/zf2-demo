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

namespace ApplicationCoreAcl\Service;

use ApplicationCoreAcl\Model\NamesResolver;
use BusinessLogicDomainUsers\Entity\UserEntity;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Permissions\Acl\AclInterface;
use Zend\Stdlib\ResponseInterface;
use Zend\View\Helper\Navigation;

class AclService implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    const EVENT_IS_NOT_ALLOWED = 'isNotAllowed';

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

        $this->getEventManager()->trigger(self::EVENT_IS_NOT_ALLOWED, $e->getTarget());

        $router = $e->getRouter();

        if ($role !== UserEntity::ROLE_GUEST) {
            $url = $router->assemble(['controller' => 'no-access'], ['name' => 'auth/default']);
        } else {
            $url = $router->assemble(['controller' => 'login'], ['name' => 'access/default']);
        }

        $response->setStatusCode(302);
        $response->getHeaders()->clearHeaders();
        $response->getHeaders()->addHeaderLine('Location', $url);

        $e->stopPropagation();

        return $response;
    }
}
