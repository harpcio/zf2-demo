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

namespace Module\ApiV1LibraryBooksTest\Controller;

use BusinessLogic\BooksTest\Entity\Provider\BookEntityProvider;
use LibraryTest\Controller\AbstractFunctionalControllerTestCase;
use Module\LibraryBooks\Form\CreateFormInputFilter;
use Module\LibraryBooks\Service\CrudService;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Test\Bootstrap;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Json\Json;

class CreateControllerFunctionalTest extends AbstractFunctionalControllerTestCase
{
    const CREATE_URL = '/api/library/books';

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

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();

        Bootstrap::setupServiceManager();
    }

    public function testCreateRequest_WithValidData()
    {
        $this->authenticateUser();

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
        $this->authenticateUser();

        $data = [];
        $this->filter->setData($data);

        $this->dispatch(self::CREATE_URL, Request::METHOD_POST, $data);

        $expectedJson = Json::encode(['error' => ['messages' => $this->filter->getMessages()]]);

        $this->assertSame($expectedJson, $this->getResponse()->getContent());
        $this->assertResponseStatusCode(Response::STATUS_CODE_400);
    }

    public function testCreateRequest_WhenServiceThrowPDOException()
    {
        $this->authenticateUser();

        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData(false);
        $dataBeforeSaving = $this->bookEntityProvider->getDataFromBookEntity($bookEntity);

        $this->filter->setData($dataBeforeSaving);

        $this->serviceMock->expects($this->once())
            ->method('create')
            ->with($this->filter)
            ->will($this->throwException(new \PDOException()));

        $this->dispatch(self::CREATE_URL, Request::METHOD_POST, $dataBeforeSaving);

        $expectedJson = '{"errorCode":503,"message":"PDO Service Unavailable"}';

        $this->assertSame($expectedJson, $this->getResponse()->getContent());
        $this->assertResponseStatusCode(Response::STATUS_CODE_503);
    }
}