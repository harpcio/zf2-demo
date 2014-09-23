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

class DeleteControllerFunctionalTest extends AbstractFunctionalControllerTestCase
{
    const DELETE_URL = '/api/library/book/%s';

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

    public function testDeleteRequest_WithExistingId()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $id = $bookEntity->getId();

        $this->serviceMock->expects($this->once())
            ->method('getById')
            ->with($id)
            ->will($this->returnValue($bookEntity));

        $this->serviceMock->expects($this->once())
            ->method('delete')
            ->with($bookEntity);

        $this->dispatch(sprintf(self::DELETE_URL, $id), Request::METHOD_DELETE);

        $expectedJson = Json::encode(['data' => "Book with id {$id} has been deleted"]);

        $this->assertSame($expectedJson, $this->getResponse()->getContent());
        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
    }

    public function testDeleteRequest_WithNotExistingId()
    {
        $id = 5;

        $this->serviceMock->expects($this->once())
            ->method('getById')
            ->with($id)
            ->will($this->throwException(new EntityNotFoundException()));

        $this->dispatch(sprintf(self::DELETE_URL, $id), Request::METHOD_DELETE);

        $expectedJson = '{"errorCode":404,"message":"The specified resource does not exist."}';

        $this->assertSame($expectedJson, $this->getResponse()->getContent());
        $this->assertResponseStatusCode(Response::STATUS_CODE_404);
    }

}