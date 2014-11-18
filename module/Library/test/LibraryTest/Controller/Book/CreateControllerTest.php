<?php

namespace LibraryTest\Controller\Book;

use Library\Controller\Book\CreateController;
use Library\Form\Book\CreateForm;
use Library\Service\Book\CrudService;
use LibraryTest\Controller\AbstractControllerTestCase;
use LibraryTest\Entity\Provider\BookEntityProvider;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\InputFilter\InputFilterInterface;
use Zend\Stdlib\Parameters;

class CreateControllerTest extends AbstractControllerTestCase
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
    private $createFormMock;

    /**
     * @var CreateController
     */
    protected $controller;

    public function setUp()
    {
        $this->init('create');

        $this->bookEntityProvider = new BookEntityProvider();

        $this->crudServiceMock = $this->getMockBuilder(CrudService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->createFormMock = $this->getMockBuilder(CreateForm::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->controller = new CreateController($this->createFormMock, $this->crudServiceMock);
        $this->controller->setEvent($this->event);
    }

    public function testIndexAction_WithGetRequest()
    {
        $this->createFormMock->expects($this->once())
            ->method('get')->will($this->returnSelf());

        $this->createFormMock->expects($this->once())
            ->method('setValue')->with('Create');

        $this->crudServiceMock->expects($this->never())
            ->method('create');

        $result = $this->controller->dispatch(new Request());

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertSame(['form' => $this->createFormMock], $result);
    }

    public function testIndexAction_WithValidPostRequest()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $data = $this->bookEntityProvider->getDataFromBookEntity($bookEntity, false);
        $data['csrf'] = 'csrfToken';

        $entityId = $bookEntity->getId();
        $inputFilterMock = $this->getMock(InputFilterInterface::class);

        $this->createFormMock->expects($this->once())
            ->method('get')->will($this->returnSelf());

        $this->createFormMock->expects($this->once())
            ->method('setValue')->with('Create');

        $this->createFormMock->expects($this->once())
            ->method('setData')->with($data);

        $this->createFormMock->expects($this->once())
            ->method('isValid')->will($this->returnValue(true));

        $this->createFormMock->expects($this->once())
            ->method('getInputFilter')->will($this->returnValue($inputFilterMock));

        $this->crudServiceMock->expects($this->once())
            ->method('create')
            ->with($inputFilterMock)
            ->will($this->returnValue($bookEntity));

        $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_POST)
                ->setPost(new Parameters($data))
        );

        $this->assertResponseStatusCode(Response::STATUS_CODE_302);
        $this->assertRedirectTo('/library/books/update/' . $entityId);
    }

    public function testIndexAction_WithInValidPostRequest()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $data = $this->bookEntityProvider->getDataFromBookEntity($bookEntity, false);
        $data['csrf'] = 'csrfToken';

        $this->createFormMock->expects($this->once())
            ->method('get')->will($this->returnSelf());

        $this->createFormMock->expects($this->once())
            ->method('setValue')->with('Create');

        $this->createFormMock->expects($this->once())
            ->method('setData')->with($data);

        $this->createFormMock->expects($this->once())
            ->method('isValid')->will($this->returnValue(false));

        $result = $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_POST)
                ->setPost(new Parameters($data))
        );

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertSame(['form' => $this->createFormMock], $result);
    }

    public function testIndexAction_WithExceptionInService()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $data = $this->bookEntityProvider->getDataFromBookEntity($bookEntity, false);
        $data['csrf'] = 'csrfToken';

        $inputFilterMock = $this->getMock(InputFilterInterface::class);

        $this->createFormMock->expects($this->once())
            ->method('get')->will($this->returnSelf());

        $this->createFormMock->expects($this->once())
            ->method('setValue')->with('Create');

        $this->createFormMock->expects($this->once())
            ->method('setData')->with($data);

        $this->createFormMock->expects($this->once())
            ->method('isValid')->will($this->returnValue(true));

        $this->createFormMock->expects($this->once())
            ->method('getInputFilter')->will($this->returnValue($inputFilterMock));

        $this->crudServiceMock->expects($this->once())
            ->method('create')
            ->with($inputFilterMock)
            ->will($this->throwException(new \InvalidArgumentException('Some error')));

        $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_POST)
                ->setPost(new Parameters($data))
        );

        $this->assertResponseStatusCode(Response::STATUS_CODE_302);
        $this->assertRedirectTo('/library/books');
    }
}