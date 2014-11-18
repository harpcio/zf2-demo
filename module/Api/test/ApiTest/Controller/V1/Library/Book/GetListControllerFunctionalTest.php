<?php

namespace ApiTest\Controller\V1\Library\Book;

use Application\Library\QueryFilter\Exception\UnrecognizedFieldException;
use Application\Library\QueryFilter\Exception\UnsupportedTypeException;
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

    public function testIndexAction_WithUnrecognizedFieldException()
    {
        $this->serviceMock->expects($this->once())
            ->method('getFilteredResults')
            ->will(
                $this->throwException(
                    new UnrecognizedFieldException(
                        sprintf('Field unrecognized in entity: %s', 'author')
                    )
                )
            );

        $this->dispatch(self::GET_LIST_URL, Request::METHOD_GET);

        $expectedJson = '{"errorCode":400,"message":"Field unrecognized in entity: author"}';

        $this->assertSame($expectedJson, $this->getResponse()->getContent());
        $this->assertResponseStatusCode(Response::STATUS_CODE_400);
    }

    public function testIndexAction_WithUnsupportedTypeException()
    {
        $this->serviceMock->expects($this->once())
            ->method('getFilteredResults')
            ->will(
                $this->throwException(
                    new UnsupportedTypeException(
                        sprintf('Unsupported condition type: %s', '$inarray')
                    )
                )
            );

        $this->dispatch(self::GET_LIST_URL, Request::METHOD_GET);

        $expectedJson = '{"errorCode":400,"message":"Unsupported condition type: $inarray"}';

        $this->assertSame($expectedJson, $this->getResponse()->getContent());
        $this->assertResponseStatusCode(Response::STATUS_CODE_400);
    }

}