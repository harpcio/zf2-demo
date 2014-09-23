<?php

namespace ApiTest\Controller\V1\Library\Book;

use Library\Form\Book\CreateFormInputFilter;
use Library\Service\Book\CrudService;
use LibraryTest\Controller\AbstractFunctionalControllerTestCase;
use LibraryTest\Entity\Provider\BookEntityProvider;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Test\Bootstrap;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Json\Json;

class CreateControllerFunctionalTest extends AbstractFunctionalControllerTestCase
{
    const CREATE_URL = '/api/library/book';

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

    public function testCreateRequest_WithValidData()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData(false);
        $dataBeforeSaving = $this->bookEntityProvider->getDataFromBookEntity($bookEntity);
        Bootstrap::setIdToEntity($bookEntity, mt_rand(1, 999));
        $dataAfterSaving = $this->bookEntityProvider->getDataFromBookEntity($bookEntity);

        $this->filter->setData($dataBeforeSaving);

        $this->serviceMock->expects($this->once())
            ->method('create')
            ->with($this->filter)
            ->will($this->returnValue($bookEntity));

        $this->serviceMock->expects($this->once())
            ->method('extractEntity')
            ->with($bookEntity)
            ->will($this->returnValue($dataAfterSaving));

        $this->dispatch(self::CREATE_URL, Request::METHOD_POST, $dataBeforeSaving);

        $expectedJson = Json::encode($dataAfterSaving);

        $this->assertSame($expectedJson, $this->getResponse()->getContent());
        $this->assertResponseStatusCode(Response::STATUS_CODE_201);
    }

    public function testCreateRequest_WithInvalidData()
    {
        $data = [];
        $this->filter->setData($data);

        $this->dispatch(self::CREATE_URL, Request::METHOD_POST, $data);

        $expectedJson = Json::encode(['error' => ['messages' => $this->filter->getMessages()]]);

        $this->assertSame($expectedJson, $this->getResponse()->getContent());
        $this->assertResponseStatusCode(Response::STATUS_CODE_400);
    }

}