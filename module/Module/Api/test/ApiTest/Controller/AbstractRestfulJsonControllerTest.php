<?php

namespace Module\ApiTest\Controller;

use LibraryTest\Controller\AbstractControllerTestCase;
use Module\Api\Exception\MethodNotAllowedException;
use Module\ApiTest\Fixture\SampleClass;
use Module\ApiTest\Fixture\SampleRestfulJsonController;
use Module\ApiTest\Fixture\SampleRestfulJsonWithOverriddenReDispatchController;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Test\Bootstrap;
use Zend\Http\Header\ContentType;
use Zend\Http\PhpEnvironment\Response;
use Zend\Http\Request;
use Zend\Mvc\Exception\RuntimeException;

class AbstractRestfulJsonControllerTest extends AbstractControllerTestCase
{
    /**
     * @var SampleRestfulJsonWithOverriddenReDispatchController
     */
    protected $controller;

    /**
     * @var MockObject
     */
    protected $sampleMock;

    public function setUp()
    {
        parent::init(SampleRestfulJsonWithOverriddenReDispatchController::class, null);

        $this->sampleMock = $this->getMock(SampleClass::class);
        $this->sampleMock->expects($this->any())
            ->method('doSomething');

        $this->controller = new SampleRestfulJsonWithOverriddenReDispatchController($this->sampleMock);
        $this->controller->setEvent($this->event);
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();

        Bootstrap::setupServiceManager();
    }

    public function testDeleteWithId()
    {
        $id = mt_rand(1, 100);

        $this->routeMatch->setParam('id', $id);

        $result = $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_DELETE)
        );

        $expected = [
            'Module\ApiTest\Fixture\DeleteController',
            [
                'id' => $id,
                'action' => 'index'
            ]
        ];

        $this->assertSame($expected, $result);
    }

    public function testDeleteWithoutId()
    {
        $result = $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_DELETE)
        );

        $expected = [
            'Module\ApiTest\Fixture\DeleteListController',
            [
                'action' => 'index'
            ]
        ];

        $this->assertSame($expected, $result);
    }

    public function testGetWithId()
    {
        $id = mt_rand(1, 100);

        $this->routeMatch->setParam('id', $id);

        $result = $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_GET)
        );

        $expected = [
            'Module\ApiTest\Fixture\GetController',
            [
                'id' => $id,
                'action' => 'index'
            ]
        ];

        $this->assertSame($expected, $result);
    }

    public function testGetWithoutId()
    {
        $result = $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_GET)
        );

        $expected = [
            'Module\ApiTest\Fixture\GetListController',
            [
                'action' => 'index'
            ]
        ];

        $this->assertSame($expected, $result);
    }

    public function testHeadWithId()
    {
        $id = mt_rand(1, 100);

        $this->routeMatch->setParam('id', $id);

        $result = $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_HEAD)
        );

        $this->assertInstanceOf(Response::class, $result);
        $this->assertSame(Response::STATUS_CODE_200, $result->getStatusCode());
    }

    public function testHeadWithoutId()
    {
        $result = $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_HEAD)
        );

        $this->assertInstanceOf(Response::class, $result);
    }

    public function testOptions()
    {
        $result = $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_OPTIONS)
        );

        $this->assertInstanceOf(Response::class, $result);

        $expectedAllowHeaders = 'Allow: OPTIONS, GET, HEAD, POST, PUT, DELETE, TRACE, PATCH';

        $this->assertSame($expectedAllowHeaders, $result->getHeaders()->get('Allow')->toString());
    }

    public function testPatchWithId()
    {
        $id = mt_rand(1, 100);

        $this->routeMatch->setParam('id', $id);

        $result = $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_PATCH)
        );

        $expected = [
            'Module\ApiTest\Fixture\PatchController',
            [
                'id' => $id,
                'action' => 'index'
            ]
        ];

        $this->assertSame($expected, $result);
    }

    public function testPatchWithoutId()
    {
        $result = $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_PATCH)
        );

        $expected = [
            'Module\ApiTest\Fixture\PatchListController',
            [
                'action' => 'index'
            ]
        ];

        $this->assertSame($expected, $result);
    }

    public function testPatchWithoutIdWhenPatchListThrowException()
    {
        $this->sampleMock->expects($this->any())
            ->method('doSomething')
            ->willThrowException(new RuntimeException());

        $result = $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_PATCH)
        );

        $this->assertInstanceOf(Response::class, $result);
        $this->assertSame(Response::STATUS_CODE_405, $result->getStatusCode());
    }

    public function testPost()
    {
        $result = $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_POST)
        );

        $expected = [
            'Module\ApiTest\Fixture\CreateController',
            [
                'action' => 'index'
            ]
        ];

        $this->assertSame($expected, $result);
    }

    public function testPostWithJsonContent()
    {
        $request = new Request();
        $request->setMethod(Request::METHOD_POST);
        $request->setContent('{"data":["someValue", "anotherValue"]}');
        $request->getHeaders()->addHeader(new ContentType('application/json'));

        $result = $this->controller->dispatch($request);

        $expected = [
            'Module\ApiTest\Fixture\CreateController',
            [
                'action' => 'index'
            ]
        ];

        $this->assertSame($expected, $result);

        $expectedPost = [
            'data' => [
                'someValue',
                'anotherValue'
            ]
        ];

        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $this->controller->getRequest();

        $this->assertSame($expectedPost, $request->getPost()->toArray());
    }

    public function testPutWithId()
    {
        $id = mt_rand(1, 100);

        $this->routeMatch->setParam('id', $id);

        $result = $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_PUT)
        );

        $expected = [
            'Module\ApiTest\Fixture\UpdateController',
            [
                'id' => $id,
                'action' => 'index'
            ]
        ];

        $this->assertSame($expected, $result);
    }

    public function testPutWithoutId()
    {
        $result = $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_PUT)
        );

        $expected = [
            'Module\ApiTest\Fixture\ReplaceListController',
            [
                'action' => 'index'
            ]
        ];

        $this->assertSame($expected, $result);
    }

    public function testNonRestfulMethodWhenAvailableInOptions()
    {
        $result = $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_TRACE)
        );

        $this->assertInstanceOf(Response::class, $result);
        $this->assertSame(Response::STATUS_CODE_405, $result->getStatusCode());
    }

    public function testNonRestfulMethodWithoutAvailableInOptions()
    {
        $this->setExpectedException(MethodNotAllowedException::class);

        $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_CONNECT)
        );
    }

    public function testRequestWhenActionIsNotFound()
    {
        parent::init(SampleRestfulJsonWithOverriddenReDispatchController::class, 'shouldBeNotFound');

        $this->controller = new SampleRestfulJsonWithOverriddenReDispatchController($this->sampleMock);
        $this->controller->setEvent($this->event);

        $result = $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_GET)
        );

        $expected = ['content' => 'Page not found'];

        $this->assertSame($expected, $result);
        $this->assertResponseStatusCode(Response::STATUS_CODE_404);
    }

    public function testRequestWhenControllerIsNotFound()
    {
        parent::init('SampleRestfulJsonController', null);

        $this->controller = new SampleRestfulJsonController();
        $this->controller->setEvent($this->event);

        $this->setExpectedException(MethodNotAllowedException::class);

        $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_GET)
        );
    }
}