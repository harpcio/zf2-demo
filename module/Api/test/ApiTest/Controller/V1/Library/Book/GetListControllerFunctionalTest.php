<?php

namespace ApiTest\Controller\V1\Library\Book;

use Library\Service\Book\CrudService;
use LibraryTest\Controller\AbstractFunctionalControllerTestCase;
use LibraryTest\Entity\Provider\BookEntityProvider;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Json\Json;

class GetListControllerFunctionalTest extends AbstractFunctionalControllerTestCase
{
    const GET_LIST_URL = '/api/library/book';

    /**
     * @var MockObject
     */
    private $serviceMock;

    /**
     * @var BookEntityProvider
     */
    private $bookEntityProvider;

    public function setUp()
    {
        parent::setUp();

        $this->bookEntityProvider = new BookEntityProvider();

        $this->serviceMock = $this->getMockBuilder(CrudService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->setMockToServiceLocator(CrudService::class, $this->serviceMock);
    }

    public function testGetListRequest_WhenEntitiesExists()
    {
        $bookEntities = [];
        $data = [];
        for ($i = 0; $i < 2; $i += 1) {
            $bookEntities[] = $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
            $data[] = $this->bookEntityProvider->getDataFromBookEntity($bookEntity);
        }

        $this->serviceMock->expects($this->once())
            ->method('getAll')
            ->will($this->returnValue($bookEntities));

        $this->serviceMock->expects($this->at(1))
            ->method('extractEntity')
            ->with($bookEntities[0])
            ->will($this->returnValue($data[0]));

        $this->serviceMock->expects($this->at(2))
            ->method('extractEntity')
            ->with($bookEntities[1])
            ->will($this->returnValue($data[1]));

        $this->dispatch(self::GET_LIST_URL, Request::METHOD_GET);

        $expectedJson = Json::encode(['data' => $data]);

        $this->assertSame($expectedJson, $this->getResponse()->getContent());
        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
    }

    public function testGetListRequest_WhenEntitiesDoNotExist()
    {
        $this->serviceMock->expects($this->once())
            ->method('getAll')
            ->will($this->returnValue([]));

        $this->dispatch(self::GET_LIST_URL, Request::METHOD_GET);

        $expectedJson = Json::encode(['data' => []]);

        $this->assertSame($expectedJson, $this->getResponse()->getContent());
        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
    }

}