<?php

namespace Module\ApiTest\Listener;

use Module\Api\Exception\MethodNotAllowedException;
use Module\Api\Listener\ResolveExceptionToJsonModelListener;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;

class ResolveExceptionToJsonModelListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ResolveExceptionToJsonModelListener
     */
    private $testedObject;

    public function setUp()
    {
        $this->testedObject = new ResolveExceptionToJsonModelListener();
    }

    public function testInvoke_WithoutError()
    {
        $event = new MvcEvent();

        $result = $this->testedObject->__invoke($event);

        $this->assertTrue($result);
    }

    public function testInvoke_WithoutException()
    {
        $event = new MvcEvent();
        $event->setError('Some error message');

        $result = $this->testedObject->__invoke($event);

        $this->assertTrue($result);
    }

    public function testInvoke_WithExceptionButNotFromApi()
    {
        $event = new MvcEvent();
        $event->setError('Some error message');
        $event->setParam('exception', new \InvalidArgumentException());

        $result = $this->testedObject->__invoke($event);

        $this->assertTrue($result);
    }

    public function testInvoke_WithApiException()
    {
        $event = new MvcEvent();
        $event->setError("The resource doesn't support the specified HTTP verb.");
        $event->setParam('exception', new MethodNotAllowedException());
        $event->setResponse(new Response());

        $result = $this->testedObject->__invoke($event);

        $this->assertInstanceOf(JsonModel::class, $result);
    }
}