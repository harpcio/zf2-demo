<?php

namespace ApiTest\Controller\V1\Library\Book;

use Doctrine\ORM\EntityNotFoundException;
use Library\Entity\BookEntity;
use Library\Service\Book\CrudService;
use LibraryTest\Controller\AbstractFunctionalControllerTestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Test\Bootstrap;
use Zend\Http\Request;
use Zend\Http\Response;

class GetControllerFunctionalTest extends AbstractFunctionalControllerTestCase
{
    const GET_URL = '/api/library/book/%s';

    /**
     * @var MockObject
     */
    private $serviceMock;

    public function setUp()
    {
        parent::setUp();

        $this->serviceMock = $this->getMockBuilder(CrudService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->setMockToServiceLocator(CrudService::class, $this->serviceMock);
    }

    public function testGetRequest_WithExistingId()
    {
        $id = 3;
        $bookEntity = $this->prepareBookEntity($id);
        $data = $this->prepareDataFromBookEntity($bookEntity);

        $this->serviceMock->expects($this->once())
            ->method('getById')
            ->with($id)
            ->will($this->returnValue($bookEntity));

        $this->serviceMock->expects($this->once())
            ->method('hydrateEntity')
            ->with($bookEntity)
            ->will($this->returnValue($data));

        $this->dispatch(sprintf(self::GET_URL, $id), Request::METHOD_GET);

        $expectedJson = '{"id":3,"title":"Short title","description":"Short description","isbn":"978-02-014-8567-7","year":2014,"publisher":"Short publisher","price":12.82}';

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

    /**
     * @param $id
     *
     * @return BookEntity
     */
    private function prepareBookEntity($id)
    {
        $bookEntity = new BookEntity();
        $bookEntity->setTitle('Short title')
            ->setDescription('Short description')
            ->setPublisher('Short publisher')
            ->setYear('2014')
            ->setPrice(12.82)
            ->setIsbn('978-02-014-8567-7');

        Bootstrap::setIdToEntity($bookEntity, $id);

        return $bookEntity;
    }

    /**
     * @param BookEntity $bookEntity
     *
     * @return array
     */
    private function prepareDataFromBookEntity(BookEntity $bookEntity)
    {
        $data = [
            'id' => $bookEntity->getId(),
            'title' => $bookEntity->getTitle(),
            'description' => $bookEntity->getDescription(),
            'isbn' => $bookEntity->getIsbn(),
            'year' => $bookEntity->getYear(),
            'publisher' => $bookEntity->getPublisher(),
            'price' => $bookEntity->getPrice()
        ];

        return $data;
    }
}