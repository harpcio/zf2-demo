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

namespace AclTest\Service;

use Acl\Model\NamesResolver;
use Acl\Service\AclService;
use BusinessLogic\Users\Entity\UserEntityInterface;
use BusinessLogic\UsersTest\Entity\Provider\UserEntityProvider;
use Module\Api\Controller\AbstractApiActionController;
use Module\Api\Exception\UnauthorizedException;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Test\Bootstrap;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Http\Header\Location;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Service\RouterFactory;
use Zend\Permissions\Acl\AclInterface;
use Zend\Stdlib\ResponseInterface;

class AclServiceTest extends \PHPUnit_Framework_TestCase
{
    const URL_NO_ACCESS = '/auth/no-access',
        URL_LOGIN = '/auth/login';

    /**
     * @var AclService
     */
    private $testedObject;

    /**
     * @var MockObject
     */
    private $authServiceMock;

    /**
     * @var MockObject
     */
    private $aclMock;

    /**
     * @var MockObject
     */
    private $namesResolverMock;

    public function setUp()
    {
        $this->authServiceMock = $this->getMockBuilder(AuthenticationServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->aclMock = $this->getMockBuilder(AclInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->namesResolverMock = $this->getMock(NamesResolver::class);

        $this->testedObject = new AclService($this->authServiceMock, $this->aclMock, $this->namesResolverMock);
    }

    public function testCheckAccess_WithValidRequest_WhenUserIsAdmin()
    {
        $userEntity = UserEntityProvider::createEntityWithRandomData();

        $event = $this->prepareEvent();

        $this->authServiceMock->expects($this->once())
            ->method('getIdentity')
            ->will($this->returnValue($userEntity));

        $this->namesResolverMock->expects($this->once())
            ->method('resolve')
            ->with($event)
            ->will(
                $this->returnValue(
                    ['module', 'controller', 'action']
                )
            );

        $this->aclMock->expects($this->once())
            ->method('isAllowed')
            ->with($userEntity->getRole(), 'module', 'controller:action')
            ->will($this->returnValue(true));

        $result = $this->testedObject->checkAccess($event);

        $this->assertInstanceOf(ResponseInterface::class, $result);
    }

    public function testCheckAccess_WithInvalidRequest_WhenCheckingAPIController()
    {
        $userEntity = UserEntityProvider::createEntityWithRandomData();

        $event = $this->prepareEvent($forApi = true);

        $this->authServiceMock->expects($this->once())
            ->method('getIdentity')
            ->will($this->returnValue($userEntity));

        $this->namesResolverMock->expects($this->once())
            ->method('resolve')
            ->with($event)
            ->will(
                $this->returnValue(
                    ['module', 'controller', 'action']
                )
            );

        $this->aclMock->expects($this->once())
            ->method('isAllowed')
            ->with($userEntity->getRole(), 'module', 'controller:action')
            ->will($this->returnValue(false));

        $this->setExpectedException(UnauthorizedException::class);

        $this->testedObject->checkAccess($event);
    }

    public function testCheckAccess_WithInvalidRequest_WhenUserIsAdmin()
    {
        $userEntity = UserEntityProvider::createEntityWithRandomData();

        $event = $this->prepareEvent();

        $this->authServiceMock->expects($this->once())
            ->method('getIdentity')
            ->will($this->returnValue($userEntity));

        $this->namesResolverMock->expects($this->once())
            ->method('resolve')
            ->with($event)
            ->will(
                $this->returnValue(
                    ['module', 'controller', 'action']
                )
            );

        $this->aclMock->expects($this->once())
            ->method('isAllowed')
            ->with($userEntity->getRole(), 'module', 'controller:action')
            ->will($this->returnValue(false));

        /** @var Response $result */
        $result = $this->testedObject->checkAccess($event);

        $this->assertInstanceOf(ResponseInterface::class, $result);

        /** @var Location $location */
        $location = $result->getHeaders()->get('Location');

        $this->assertSame($location->getUri(), self::URL_NO_ACCESS);
    }

    public function testCheckAccess_WithInvalidRequest_WhenUserIsGuest()
    {
        $event = $this->prepareEvent();

        $this->authServiceMock->expects($this->once())
            ->method('getIdentity')
            ->will($this->returnValue(null));

        $this->namesResolverMock->expects($this->once())
            ->method('resolve')
            ->with($event)
            ->will(
                $this->returnValue(
                    ['module', 'controller', 'action']
                )
            );

        $this->aclMock->expects($this->once())
            ->method('isAllowed')
            ->with(UserEntityInterface::ROLE_GUEST, 'module', 'controller:action')
            ->will($this->returnValue(false));

        /** @var Response $result */
        $result = $this->testedObject->checkAccess($event);

        $this->assertInstanceOf(ResponseInterface::class, $result);

        /** @var Location $location */
        $location = $result->getHeaders()->get('Location');

        $this->assertSame($location->getUri(), self::URL_LOGIN);
    }

    private function prepareEvent($forApi = false)
    {
        if ($forApi) {
            $controllerMock = $this->getMock(AbstractApiActionController::class);
        } else {
            $controllerMock = $this->getMock(AbstractActionController::class);
        }

        $routerFactory = new RouterFactory();
        $router = $routerFactory->createService(Bootstrap::getServiceManager());

        $event = new MvcEvent();
        $event->setTarget($controllerMock);
        $event->setRouter($router);
        $event->setResponse(new Response());

        return $event;
    }
}