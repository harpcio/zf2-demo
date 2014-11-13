<?php

namespace LibraryTest\Service\Book;

use Application\Library\QueryFilter\QueryFilter;
use Library\Entity\BookEntity;
use Library\Repository\BookRepositoryInterface;
use Library\Service\Book\CrudService;
use LibraryTest\Entity\Provider\BookEntityProvider;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Test\Bootstrap;
use Zend\InputFilter\InputFilterInterface;

class CrudServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CrudService
     */
    private $testedObj;

    /**
     * @var MockObject
     */
    private $bookRepositoryMock;

    /**
     * @var BookEntityProvider
     */
    private $bookEntityProvider;

    public function setUp()
    {
        $this->bookEntityProvider = new BookEntityProvider();

        $this->bookRepositoryMock = $this->getMock(BookRepositoryInterface::class);

        $this->testedObj = new CrudService($this->bookRepositoryMock);
    }

    public function testCreate_WithValidResponse()
    {
        $newBookEntity = new BookEntity();
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $data = $this->bookEntityProvider->getDataFromBookEntity($bookEntity);

        $filterMock = $this->getMock(InputFilterInterface::class);

        $filterMock->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));

        $filterMock->expects($this->once())
            ->method('getValues')
            ->will($this->returnValue($data));

        $this->bookRepositoryMock->expects($this->once())
            ->method('createNewEntity')
            ->will($this->returnValue($newBookEntity));

        $this->bookRepositoryMock->expects($this->once())
            ->method('hydrate')
            ->with($newBookEntity, $data)
            ->will($this->returnValue($bookEntity));

        $this->bookRepositoryMock->expects($this->once())
            ->method('save')
            ->with($bookEntity);

        $this->testedObj->create($filterMock);
    }

    public function testCreate_WithInvalidDataInFilter()
    {
        $filterMock = $this->getMock(InputFilterInterface::class);

        $filterMock->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(false));

        $this->setExpectedException('LogicException');

        $this->testedObj->create($filterMock);
    }

    public function testUpdate_WithValidResponse()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $newBookEntity = $this->bookEntityProvider->getBookEntityWithRandomData($withRandomId = false);
        $data = $this->bookEntityProvider->getDataFromBookEntity($newBookEntity);
        Bootstrap::setIdToEntity($newBookEntity, $bookEntity->getId());

        $filterMock = $this->getMock(InputFilterInterface::class);

        $filterMock->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));

        $filterMock->expects($this->once())
            ->method('getValues')
            ->will($this->returnValue($data));

        $this->bookRepositoryMock->expects($this->once())
            ->method('hydrate')
            ->with($bookEntity, $data)
            ->will($this->returnValue($newBookEntity));

        $this->bookRepositoryMock->expects($this->once())
            ->method('save')
            ->with($newBookEntity);

        $result = $this->testedObj->update($bookEntity, $filterMock);

        $this->assertSame($newBookEntity, $result);
    }

    public function testUpdate_WithInValidDataInFilter()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $filterMock = $this->getMock(InputFilterInterface::class);

        $filterMock->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(false));

        $this->setExpectedException('LogicException');

        $this->testedObj->update($bookEntity, $filterMock);
    }

    public function testDelete()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();

        $this->bookRepositoryMock->expects($this->once())
            ->method('delete')
            ->with($bookEntity);

        $this->testedObj->delete($bookEntity);
    }

    public function testGetById_WithValidResponse()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $id = $bookEntity->getId();

        $this->bookRepositoryMock->expects($this->once())
            ->method('find')
            ->with($id)
            ->will($this->returnValue($bookEntity));

        $result = $this->testedObj->getById($id);

        $this->assertSame($bookEntity, $result);
    }

    public function testGetById_WithInvalidArgumentException()
    {
        $id = null;

        $this->bookRepositoryMock->expects($this->never())
            ->method('find');

        $this->setExpectedException('InvalidArgumentException');

        $this->testedObj->getById($id);
    }

    public function testGetById_WithNotFoundException()
    {
        $id = 12;

        $this->bookRepositoryMock->expects($this->once())
            ->method('find')
            ->with($id)
            ->will($this->returnValue(null));

        $this->setExpectedException('Doctrine\ORM\EntityNotFoundException');

        $this->testedObj->getById($id);
    }

    public function testGetFilteredResult()
    {
        $bookEntity1 = $this->bookEntityProvider->getBookEntityWithRandomData();
        $bookEntity2 = $this->bookEntityProvider->getBookEntityWithRandomData();

        $books = [$bookEntity1, $bookEntity2];

        $this->bookRepositoryMock->expects($this->once())
            ->method('findBy')
            ->will($this->returnValue($books));

        $result = $this->testedObj->getFilteredResults(new QueryFilter());

        $this->assertSame($books, $result);
    }

    public function testExtractEntity()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $data = $this->bookEntityProvider->getDataFromBookEntity($bookEntity);

        $this->bookRepositoryMock->expects($this->once())
            ->method('extract')
            ->with($bookEntity)
            ->will($this->returnValue($data));

        $result = $this->testedObj->extractEntity($bookEntity);

        $this->assertSame($data, $result);
    }


}