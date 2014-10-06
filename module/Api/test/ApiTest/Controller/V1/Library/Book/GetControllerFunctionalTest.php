<?php

namespace ApiTest\Controller\V1\Library\Book;

use Doctrine\ORM\EntityNotFoundException;
use Library\Service\Book\CrudService;
use LibraryTest\Controller\AbstractFunctionalControllerTestCase;
use LibraryTest\Entity\Provider\BookEntityProvider;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Json\Json;

class GetControllerFunctionalTest extends AbstractFunctionalControllerTestCase
{
    const GET_URL = '/api/library/book/%s';

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

    public function testGetRequest_WithExistingId()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $data = $this->bookEntityProvider->getDataFromBookEntity($bookEntity);
        $id = $bookEntity->getId();

        $this->serviceMock->expects($this->once())
            ->method('getById')
            ->with($id)
            ->will($this->returnValue($bookEntity));

        $this->serviceMock->expects($this->once())
            ->method('extractEntity')
            ->with($bookEntity)
            ->will($this->returnValue($data));

        $this->dispatch(sprintf(self::GET_URL, $id), Request::METHOD_GET);

        $expectedJson = Json::encode($data);

        $this->assertSame($expectedJson, $this->getResponse()->getContent());
        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
    }

    public function testGetRequest_WithNotExistingId()
    {
        $id = 5;

        $this->serviceMock->expects($this->once())
            ->method('getById')
            ->with($id)
            ->will($this->throwException(new EntityNotFoundException()));

        $this->dispatch(sprintf(self::GET_URL, $id), Request::METHOD_GET);

        $expectedJson = '{"errorCode":404,"message":"The specified resource does not exist."}';

        $this->assertSame($expectedJson, $this->getResponse()->getContent());
        $this->assertResponseStatusCode(Response::STATUS_CODE_404);
    }

    public function testGetRequest_WhenServiceThrowPDOException()
    {
        $id = 5;

        $this->serviceMock->expects($this->once())
            ->method('getById')
            ->with($id)
            ->will($this->throwException(new \PDOException()));

        $this->dispatch(sprintf(self::GET_URL, $id), Request::METHOD_GET);

        $expectedJson = '{"errorCode":503,"message":"PDO Service Unavailable"}';

        $this->assertSame($expectedJson, $this->getResponse()->getContent());
        $this->assertResponseStatusCode(Response::STATUS_CODE_503);
    }

}