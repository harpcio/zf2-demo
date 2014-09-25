<?php

namespace LibraryTest\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Library\Entity\BookEntity;
use Library\Repository\BookRepository;
use LibraryTest\Entity\Provider\BookEntityProvider;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class BookRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BookRepository
     */
    private $testedObj;

    /**
     * @var MockObject
     */
    private $entityManagerMock;

    /**
     * @var ClassMetadata
     */
    private $classMetadata;

    /**
     * @var MockObject
     */
    private $hydratorMock;

    /**
     * @var BookEntityProvider
     */
    private $bookEntityProvider;

    public function setUp()
    {
        $this->bookEntityProvider = new BookEntityProvider();

        $this->entityManagerMock = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->hydratorMock = $this->getMockBuilder(DoctrineObject::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->classMetadata = new ClassMetadata(BookEntity::class);

        $this->testedObj = new BookRepository($this->entityManagerMock, $this->classMetadata);
        $this->testedObj->setHydrator($this->hydratorMock);
    }

    public function testCreateNewEntity()
    {
        $bookEntity = $this->testedObj->createNewEntity();

        $this->assertInstanceOf(BookEntity::class, $bookEntity);
    }

    public function testHydrate()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData(false);
        $data = $this->bookEntityProvider->getDataFromBookEntity($bookEntity);

        $this->hydratorMock->expects($this->once())
            ->method('hydrate')
            ->with($data, $bookEntity);

        $this->testedObj->hydrate($bookEntity, $data);
    }

    public function testHydrate_WithoutHydrator()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData(false);
        $data = $this->bookEntityProvider->getDataFromBookEntity($bookEntity);

        $this->setExpectedException('LogicException', 'Hydrator has not been injected!');

        $testedObj = new BookRepository($this->entityManagerMock, $this->classMetadata);
        $testedObj->hydrate($bookEntity, $data);
    }

    public function testExtract()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();

        $this->hydratorMock->expects($this->once())
            ->method('extract')
            ->with($bookEntity);

        $this->testedObj->extract($bookEntity);
    }

    public function testExtract_WithoutHydrator()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();

        $this->setExpectedException('LogicException', 'Hydrator has not been injected!');

        $testedObj = new BookRepository($this->entityManagerMock, $this->classMetadata);
        $testedObj->extract($bookEntity);
    }

    public function testSave_WithFlush()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData(false);

        $this->entityManagerMock->expects($this->once())
            ->method('persist')
            ->with($bookEntity);

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        $this->testedObj->save($bookEntity);
    }

    public function testSave_WithoutFlush()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData(false);

        $this->entityManagerMock->expects($this->once())
            ->method('persist')
            ->with($bookEntity);

        $this->entityManagerMock->expects($this->never())
            ->method('flush');

        $this->testedObj->save($bookEntity, false);
    }

    public function testDelete_WithFlush()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();

        $this->entityManagerMock->expects($this->once())
            ->method('remove')
            ->with($bookEntity);

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        $this->testedObj->delete($bookEntity);
    }

    public function testDelete_WithoutFlush()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();

        $this->entityManagerMock->expects($this->once())
            ->method('remove')
            ->with($bookEntity);

        $this->entityManagerMock->expects($this->never())
            ->method('flush');

        $this->testedObj->delete($bookEntity, false);
    }

}