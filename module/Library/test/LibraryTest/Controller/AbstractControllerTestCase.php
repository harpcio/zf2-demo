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

namespace LibraryTest\Controller;

use BusinessLogic\Users\Entity\UserEntity;
use BusinessLogic\UsersTest\Entity\Provider\UserEntityProvider;
use Zend\Authentication\AuthenticationService;
use Test\Bootstrap;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Service\RouterFactory;
use PHPUnit_Framework_ExpectationFailedException;

abstract class AbstractControllerTestCase extends \PHPUnit_Framework_TestCase
{

    /**
     * @var RouteMatch
     */
    protected $routeMatch;

    /**
     * @var MvcEvent
     */
    protected $event;

    /**
     * @var mixed
     */
    protected $controller;

    public function init($controllerName, $actionName = 'index')
    {
        $this->routeMatch = new RouteMatch(
            [
                'controller' => $controllerName,
                'action' => $actionName
            ]
        );

        $this->event = new MvcEvent();
        $this->event->setRouteMatch($this->routeMatch);
        $this->event->setRouter((new RouterFactory())->createService(Bootstrap::getServiceManager()));

        $this->prepareAuthenticateMock();
    }

    /**
     * Creates and authenticates a user.
     *
     * @param array $params
     *
     * @return UserEntity
     */
    protected function authenticateUser(array $params = [])
    {
        $userEntity = UserEntityProvider::createEntityWithRandomData($params);

        $this->prepareAuthenticateMock(true, $userEntity);

        return $userEntity;
    }

    /**
     * @param bool       $hasIdentity
     * @param UserEntity $userEntity
     */
    protected function prepareAuthenticateMock($hasIdentity = false, UserEntity $userEntity = null)
    {
        $authMock = $this->getMockBuilder(AuthenticationService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $authMock->expects($this->any())
            ->method('hasIdentity')
            ->will($this->returnValue($hasIdentity));

        $authMock->expects($this->any())
            ->method('getIdentity')
            ->will($this->returnValue($userEntity));

        $sm = Bootstrap::getServiceManager();
        $sm->setAllowOverride(true);
        $sm->setService(AuthenticationService::class, $authMock);
        $sm->setAllowOverride(false);
    }

    protected function assertResponseStatusCode($code)
    {
        /** @var Response $response */
        $response = $this->controller->getResponse();
        $this->assertSame($code, $response->getStatusCode());
    }

    /**
     * Get response header by key
     *
     * @param  string $header
     *
     * @return \Zend\Http\Header\HeaderInterface|false
     */
    protected function getResponseHeader($header)
    {
        /** @var Response $response */
        $response = $this->controller->getResponse();
        $headers = $response->getHeaders();
        $responseHeader = $headers->get($header, false);
        return $responseHeader;
    }

    /**
     * Assert that response is a redirect
     */
    protected function assertRedirect()
    {
        $responseHeader = $this->getResponseHeader('Location');
        if (false === $responseHeader) {
            throw new PHPUnit_Framework_ExpectationFailedException(
                'Failed asserting response is a redirect'
            );
        }
        $this->assertNotEquals(false, $responseHeader);
    }

    /**
     * Assert that response is NOT a redirect
     */
    protected function assertNotRedirect()
    {
        $responseHeader = $this->getResponseHeader('Location');
        if (false !== $responseHeader) {
            throw new PHPUnit_Framework_ExpectationFailedException(
                sprintf(
                    'Failed asserting response is NOT a redirect, actual redirection is "%s"',
                    $responseHeader->getFieldValue()
                )
            );
        }
        $this->assertFalse($responseHeader);
    }

    /**
     * Assert that response redirects to given URL
     *
     * @param  string $url
     *
     * @throws \PHPUnit_Framework_ExpectationFailedException
     */
    protected function assertRedirectTo($url)
    {
        $responseHeader = $this->getResponseHeader('Location');
        if (!$responseHeader) {
            throw new PHPUnit_Framework_ExpectationFailedException(
                'Failed asserting response is a redirect'
            );
        }
        if ($url != $responseHeader->getFieldValue()) {
            throw new PHPUnit_Framework_ExpectationFailedException(
                sprintf(
                    'Failed asserting response redirects to "%s", actual redirection is "%s"',
                    $url,
                    $responseHeader->getFieldValue()
                )
            );
        }
        $this->assertEquals($url, $responseHeader->getFieldValue());
    }

    /**
     * Assert that response does not redirect to given URL
     *
     * @param  string $url
     *
     * @throws \PHPUnit_Framework_ExpectationFailedException
     */
    protected function assertNotRedirectTo($url)
    {
        $responseHeader = $this->getResponseHeader('Location');
        if (!$responseHeader) {
            throw new PHPUnit_Framework_ExpectationFailedException(
                'Failed asserting response is a redirect'
            );
        }
        if ($url == $responseHeader->getFieldValue()) {
            throw new PHPUnit_Framework_ExpectationFailedException(
                sprintf(
                    'Failed asserting response redirects to "%s"',
                    $url
                )
            );
        }
        $this->assertNotEquals($url, $responseHeader->getFieldValue());
    }

    /**
     * Assert that redirect location matches pattern
     *
     * @param  string $pattern
     *
     * @throws \PHPUnit_Framework_ExpectationFailedException
     */
    protected function assertRedirectRegex($pattern)
    {
        $responseHeader = $this->getResponseHeader('Location');
        if (!$responseHeader) {
            throw new PHPUnit_Framework_ExpectationFailedException(
                'Failed asserting response is a redirect'
            );
        }
        if (!preg_match($pattern, $responseHeader->getFieldValue())) {
            throw new PHPUnit_Framework_ExpectationFailedException(
                sprintf(
                    'Failed asserting response redirects to URL MATCHING "%s", actual redirection is "%s"',
                    $pattern,
                    $responseHeader->getFieldValue()
                )
            );
        }
        $this->assertTrue((bool)preg_match($pattern, $responseHeader->getFieldValue()));
    }

    /**
     * Assert that redirect location does not match pattern
     *
     * @param  string $pattern
     *
     * @throws \PHPUnit_Framework_ExpectationFailedException
     */
    protected function assertNotRedirectRegex($pattern)
    {
        $responseHeader = $this->getResponseHeader('Location');
        if (!$responseHeader) {
            throw new PHPUnit_Framework_ExpectationFailedException(
                'Failed asserting response is a redirect'
            );
        }
        if (preg_match($pattern, $responseHeader->getFieldValue())) {
            throw new PHPUnit_Framework_ExpectationFailedException(
                sprintf(
                    'Failed asserting response DOES NOT redirect to URL MATCHING "%s"',
                    $pattern
                )
            );
        }
        $this->assertFalse((bool)preg_match($pattern, $responseHeader->getFieldValue()));
    }

}