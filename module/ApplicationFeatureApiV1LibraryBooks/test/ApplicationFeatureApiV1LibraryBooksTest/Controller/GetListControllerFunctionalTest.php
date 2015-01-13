<?php
/**
 * This file is part of Zf2-demo package
 *
 * @author Rafal Ksiazek <harpcio@gmail.com>
 * @copyright Rafal Ksiazek F.H.U. Studioars
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApplicationFeatureApiV1LibraryBooksTest\Controller;

use BusinessLogicDomainBooksTest\Entity\Provider\BookEntityProvider;
use ApplicationLibrary\QueryFilter\Exception\UnrecognizedFieldException;
use ApplicationLibrary\QueryFilter\Exception\UnsupportedTypeException;
use ApplicationLibraryTest\Controller\AbstractFunctionalControllerTestCase;
use ApplicationFeatureLibraryBooks\Service\FilterResultsService;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Test\Bootstrap;
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

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();

        Bootstrap::setupServiceManager();
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