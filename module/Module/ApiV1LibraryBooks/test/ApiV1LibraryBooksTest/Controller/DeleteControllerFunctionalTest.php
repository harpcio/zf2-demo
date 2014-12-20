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
use Doctrine\ORM\EntityNotFoundException;
use LibraryTest\Controller\AbstractFunctionalControllerTestCase;
use Module\LibraryBooks\Service\CrudService;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Test\Bootstrap;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Json\Json;

class DeleteControllerFunctionalTest extends AbstractFunctionalControllerTestCase
{
    const DELETE_URL = '/api/library/books/%s';

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

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();

        Bootstrap::setupServiceManager();
    }

    public function testDeleteRequest_WithExistingId()
    {
        $this->authenticateUser();

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

        $expectedJson = Json::encode(['data' => "Books with id {$id} has been deleted"]);

        $this->assertSame($expectedJson, $this->getResponse()->getContent());
        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
    }

    public function testDeleteRequest_WithNotExistingId()
    {
        $this->authenticateUser();

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

    public function testDeleteRequest_WhenServiceThrowPDOException()
    {
        $this->authenticateUser();

        $id = 5;

        $this->serviceMock->expects($this->once())
            ->method('getById')
            ->with($id)
            ->will($this->throwException(new \PDOException()));

        $this->dispatch(sprintf(self::DELETE_URL, $id), Request::METHOD_DELETE);

        $expectedJson = '{"errorCode":503,"message":"PDO Service Unavailable"}';

        $this->assertSame($expectedJson, $this->getResponse()->getContent());
        $this->assertResponseStatusCode(Response::STATUS_CODE_503);
    }
}