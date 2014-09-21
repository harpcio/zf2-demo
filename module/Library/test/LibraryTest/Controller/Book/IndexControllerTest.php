<?php

namespace LibraryTest\Controller\Book;

use Library\Controller\Book\IndexController;
use Library\Service\Book\CrudService;
use LibraryTest\Controller\AbstractControllerTestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Http\Request;
use Zend\Http\Response;

class IndexControllerTest extends AbstractControllerTestCase
{
    /**
     * @var MockObject
     */
    private $crudServiceMock;

    /**
     * @var IndexController
     */
    protected $controller;

    public function setUp()
    {
        parent::setUp('index');

        $this->crudServiceMock = $this->getMockBuilder(CrudService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->controller = new IndexController($this->crudServiceMock);
        $this->controller->setEvent($this->event);
    }

    public function testIndexAction_WithGetRequest()
    {
        $books = [
            'book one',
            'book two'
        ];

        $this->crudServiceMock->expects($this->once())
            ->method('getBooks')
            ->will($this->returnValue($books));

        $result = $this->controller->dispatch(new Request());

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertSame(['books' => $books], $result);
    }

}