<?php

namespace LibraryTest\Controller\Book;

use Library\Controller\Book\ReadController;
use Library\Service\Book\CrudService;
use LibraryTest\Controller\AbstractControllerTestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Http\Request;
use Zend\Http\Response;

class ReadControllerTest extends AbstractControllerTestCase
{

    /**
     * @var MockObject
     */
    private $crudServiceMock;

    /**
     * @var ReadController
     */
    protected $controller;

    public function setUp()
    {
        parent::setUp('read');

        $this->crudServiceMock = $this->getMockBuilder(CrudService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->controller = new ReadController($this->crudServiceMock);
        $this->controller->setEvent($this->event);
    }

    public function testIndexAction()
    {
        $id   = 343;
        $book = ['title' => 'some title', 'price' => 342.81];

        $this->crudServiceMock->expects($this->once())
            ->method('getById')
            ->with($id)
            ->will($this->returnValue($book));

        $this->routeMatch->setParam('id', $id);
        $result = $this->controller->dispatch(new Request());

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertSame(['book' => $book], $result);
    }

    public function testIndexAction_WithExceptionInService()
    {
        $id = 343;

        $this->crudServiceMock->expects($this->once())
            ->method('getById')
            ->with($id)
            ->will($this->throwException(new \InvalidArgumentException()));

        $this->routeMatch->setParam('id', $id);
        $this->controller->dispatch(new Request());

        $this->assertResponseStatusCode(Response::STATUS_CODE_302);
        $this->assertRedirectTo('/library/book');
    }

}