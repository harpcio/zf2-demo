<?php

namespace LibraryTest\Controller\Book;

use Library\Controller\Book\ReadController;
use Library\Service\Book\CrudService;
use LibraryTest\Controller\AbstractControllerTestCase;
use LibraryTest\Entity\Provider\BookEntityProvider;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Http\Request;
use Zend\Http\Response;

class ReadControllerTest extends AbstractControllerTestCase
{
    /**
     * @var BookEntityProvider
     */
    private $bookEntityProvider;

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

        $this->bookEntityProvider = new BookEntityProvider();

        $this->crudServiceMock = $this->getMockBuilder(CrudService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->controller = new ReadController($this->crudServiceMock);
        $this->controller->setEvent($this->event);
    }

    public function testIndexAction_WithValidGetRequest()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $id = $bookEntity->getId();

        $this->crudServiceMock->expects($this->once())
            ->method('getById')
            ->with($id)
            ->will($this->returnValue($bookEntity));

        $this->routeMatch->setParam('id', $id);
        $result = $this->controller->dispatch(new Request());

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertSame(['book' => $bookEntity], $result);
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