<?php

namespace ApiTest\Controller\V1\Library\Book;

use Library\Service\Book\CrudService;
use Library\Service\Book\FilterResultsService;
use LibraryTest\Controller\AbstractFunctionalControllerTestCase;
use LibraryTest\Entity\Provider\BookEntityProvider;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Json\Json;

class GetListControllerFunctionalTest extends AbstractFunctionalControllerTestCase
{
    const GET_LIST_URL = '/api/library/books';

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

        $this->serviceMock = $this->getMockBuilder(FilterResultsService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->setMockToServiceLocator(FilterResultsService::class, $this->serviceMock);
    }

    public function testGetListRequest_WhenEntitiesExists()
    {
        $data = [];
        for ($i = 0; $i < 2; $i += 1) {
            $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
            $data[] = $this->bookEntityProvider->getDataFromBookEntity($bookEntity);
        }

        $this->serviceMock->expects($this->once())
            ->method('getFilteredResults')
            ->will($this->returnValue($data));

        $this->dispatch(self::GET_LIST_URL, Request::METHOD_GET);

        $expectedJson = Json::encode(['data' => $data]);

        $this->assertSame($expectedJson, $this->getResponse()->getContent());
        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
    }

    public function testGetListRequest_WhenEntitiesDoNotExist()
    {
        $this->serviceMock->expects($this->once())
            ->method('getFilteredResults')
            ->will($this->returnValue([]));

        $this->dispatch(self::GET_LIST_URL, Request::METHOD_GET);

        $expectedJson = Json::encode(['data' => []]);

        $this->assertSame($expectedJson, $this->getResponse()->getContent());
        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
    }

    public function testGetListRequest_WhenServiceThrowException()
    {
        $this->serviceMock->expects($this->once())
            ->method('getFilteredResults')
            ->will($this->throwException(new \PDOException()));

        $this->dispatch(self::GET_LIST_URL, Request::METHOD_GET);

        $expectedJson = '{"errorCode":503,"message":"PDO Service Unavailable"}';

        $this->assertSame($expectedJson, $this->getResponse()->getContent());
        $this->assertResponseStatusCode(Response::STATUS_CODE_503);
    }

}