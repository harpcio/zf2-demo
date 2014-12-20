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

namespace Module\AuthTest\Controller;

use Module\Auth\Controller\LogoutController;
use Module\Auth\Service\LogoutService;
use LibraryTest\Controller\AbstractControllerTestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Http\Request;
use Zend\Http\Response;

class LogoutControllerTest extends AbstractControllerTestCase
{
    /**
     * @var LogoutController
     */
    protected $controller;

    /**
     * @var MockObject
     */
    private $logoutService;

    public function setUp()
    {
        $this->init('logout');

        $this->logoutService = $this->getMockBuilder(LogoutService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->controller = new LogoutController($this->logoutService);
        $this->controller->setEvent($this->event);
    }

    public function testAction_WithGetRequest()
    {
        $this->logoutService->expects($this->once())
            ->method('logout');

        $this->controller->dispatch(new Request());

        $this->assertResponseStatusCode(Response::STATUS_CODE_302);
        $this->assertRedirectTo('/');
    }

    public function testAction_WithExceptionInService()
    {
        $this->logoutService->expects($this->once())
            ->method('logout')
            ->will($this->throwException(new \Exception('Some exception')));

        $this->controller->dispatch(new Request());

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertNotRedirect();
    }

}