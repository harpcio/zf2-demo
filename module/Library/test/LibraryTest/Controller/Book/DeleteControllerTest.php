<?php

namespace LibraryTest\Controller\Book;

use Doctrine\ORM\EntityNotFoundException;
use Library\Controller\Book\DeleteController;
use Library\Form\DeleteForm;
use Library\Service\Book\CrudService;
use LibraryTest\Controller\AbstractControllerTestCase;
use LibraryTest\Entity\Provider\BookEntityProvider;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Stdlib\Parameters;

class DeleteControllerTest extends AbstractControllerTestCase
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
     * @var MockObject
     */
    private $deleteFormMock;

    /**
     * @var DeleteController
     */
    protected $controller;

    public function setUp()
    {
        parent::setUp('delete');

        $this->bookEntityProvider = new BookEntityProvider();

        $this->crudServiceMock = $this->getMockBuilder(CrudService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->deleteFormMock = $this->getMock(DeleteForm::class);

        $this->controller = new DeleteController($this->deleteFormMock, $this->crudServiceMock);
        $this->controller->setEvent($this->event);
    }

    public function testIndexAction_WithGetRequest()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $id = $bookEntity->getId();

        $this->deleteFormMock->expects($this->once())
            ->method('get')->will($this->returnSelf());

        $this->deleteFormMock->expects($this->once())
            ->method('setValue')->with($id);

        $this->crudServiceMock->expects($this->once())
            ->method('getById')
            ->with($id)
            ->will($this->returnValue($bookEntity));

        $this->routeMatch->setParam('id', $id);
        $result = $this->controller->dispatch(new Request());

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertSame(
            [
                'form' => $this->deleteFormMock,
                'book' => $bookEntity
            ],
            $result
        );
    }

    public function testIndexAction_WithValidPostRequest()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $id = $bookEntity->getId();

        $data = [
            'id' => $id,
            'csrf' => 'csrfToken',
            'submit' => 'Delete'
        ];

        $this->crudServiceMock->expects($this->once())
            ->method('getById')
            ->with($id)
            ->will($this->returnValue($bookEntity));

        $this->deleteFormMock->expects($this->once())
            ->method('setData')->with($data);

        $this->deleteFormMock->expects($this->once())
            ->method('isValid')->will($this->returnValue(true));

        $this->crudServiceMock->expects($this->once())
            ->method('delete')
            ->with($bookEntity);

        $this->routeMatch->setParam('id', $id);

        $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_POST)
                ->setPost(new Parameters($data))
        );

        $this->assertResponseStatusCode(Response::STATUS_CODE_302);
        $this->assertRedirectTo('/library/books');
    }

    public function testIndexAction_WithInValidPostRequest()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $id = $bookEntity->getId();

        $data = [];

        $this->crudServiceMock->expects($this->once())
            ->method('getById')
            ->with($id)
            ->will($this->returnValue($bookEntity));

        $this->deleteFormMock->expects($this->once())
            ->method('setData')->with($data);

        $this->deleteFormMock->expects($this->once())
            ->method('isValid')->will($this->returnValue(false));

        $this->routeMatch->setParam('id', $id);

        $result = $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_POST)
                ->setPost(new Parameters($data))
        );

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertSame(
            [
                'form' => $this->deleteFormMock,
                'book' => $bookEntity
            ],
            $result
        );
    }

    public function testIndexAction_WithExceptionInService()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $id = $bookEntity->getId();

        $data = [];

        $this->crudServiceMock->expects($this->once())
            ->method('getById')
            ->with($id)
            ->will($this->throwException(new EntityNotFoundException()));

        $this->routeMatch->setParam('id', $id);

        $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_POST)
                ->setPost(new Parameters($data))
        );

        $this->assertResponseStatusCode(Response::STATUS_CODE_302);
        $this->assertRedirectTo('/library/books');
    }

}