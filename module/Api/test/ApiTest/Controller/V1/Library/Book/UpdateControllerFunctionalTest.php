<?php

namespace ApiTest\Controller\V1\Library\Book;

use Api\Exception\NotFoundException;
use Library\Form\Book\CreateFormInputFilter;
use Library\Service\Book\CrudService;
use LibraryTest\Controller\AbstractFunctionalControllerTestCase;
use LibraryTest\Entity\Provider\BookEntityProvider;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Test\Bootstrap;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Json\Json;

class UpdateControllerFunctionalTest extends AbstractFunctionalControllerTestCase
{
    const UPDATE_URL = '/api/library/book/%s';

    /**
     * @var MockObject
     */
    private $serviceMock;

    /**
     * @var BookEntityProvider
     */
    private $bookEntityProvider;

    /**
     * @var CreateFormInputFilter
     */
    private $filter;

    public function setUp()
    {
        parent::setUp();

        $this->bookEntityProvider = new BookEntityProvider();

        $this->serviceMock = $this->getMockBuilder(CrudService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->setMockToServiceLocator(CrudService::class, $this->serviceMock);

        $this->filter = $this->getApplicationServiceLocator()->get(CreateFormInputFilter::class);
    }

    public function testUpdateRequest_WithValidData()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $id = $bookEntity->getId();

        $newBookEntity = $this->bookEntityProvider->getBookEntityWithRandomData(false);
        $postData = $this->bookEntityProvider->getDataFromBookEntity($newBookEntity);
        Bootstrap::setIdToEntity($newBookEntity, $id);
        $dataAfterSaving = $this->bookEntityProvider->getDataFromBookEntity($newBookEntity);

        $this->serviceMock->expects($this->once())
            ->method('getById')
            ->with($id)
            ->will($this->returnValue($bookEntity));

        $this->filter->setData($postData);

        $this->serviceMock->expects($this->once())
            ->method('update')
            ->with($bookEntity, $this->filter)
            ->will($this->returnValue($newBookEntity));

        $this->serviceMock->expects($this->once())
            ->method('extractEntity')
            ->with($newBookEntity)
            ->will($this->returnValue($dataAfterSaving));

        $this->dispatch(sprintf(self::UPDATE_URL, $id), Request::METHOD_PUT, $postData);

        $expectedJson = Json::encode($dataAfterSaving);

        $this->assertSame($expectedJson, $this->getResponse()->getContent());
        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
    }

    public function testUpdateRequest_WithInvalidData()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $id = $bookEntity->getId();

        $postData = [];
        $this->filter->setData($postData);

        $this->dispatch(sprintf(self::UPDATE_URL, $id), Request::METHOD_PUT, $postData);

        $expectedJson = Json::encode(['error' => ['messages' => $this->filter->getMessages()]]);

        $this->assertSame($expectedJson, $this->getResponse()->getContent());
        $this->assertResponseStatusCode(Response::STATUS_CODE_400);
    }

    public function testUpdateRequest_WithInvalidId()
    {
        $id = 154;

        $postData = [];
        $this->filter->setData($postData);

        $this->serviceMock->expects($this->once())
            ->method('getById')
            ->with($id)
            ->will($this->throwException(new NotFoundException()));

        $this->dispatch(sprintf(self::UPDATE_URL, $id), Request::METHOD_PUT, $postData);

        $expectedJson = '{"errorCode":404,"message":"The specified resource does not exist."}';

        $this->assertSame($expectedJson, $this->getResponse()->getContent());
        $this->assertResponseStatusCode(Response::STATUS_CODE_404);
    }

}