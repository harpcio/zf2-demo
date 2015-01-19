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

namespace BusinessLogicDomainBooksTest\Repository;

use ApplicationDataAccessDoctrineORMLibrary\QueryFilter\Command\Repository\BetweenCommand;
use ApplicationDataAccessDoctrineORMLibrary\QueryFilter\Command\Repository\OffsetCommand;
use ApplicationLibraryTest\Repository\AbstractRepositoryTestCase;
use BusinessLogicDomainBooks\Entity\BookEntity;
use BusinessLogicDomainBooks\Repository\BooksRepository;
use BusinessLogicDomainBooksTest\Entity\Provider\BookEntityProvider;
use BusinessLogicLibrary\QueryFilter\Command\Repository\CommandCollection;
use BusinessLogicLibrary\QueryFilter\Exception\UnrecognizedFieldException;
use BusinessLogicLibrary\QueryFilter\Exception\UnsupportedTypeException;
use BusinessLogicLibrary\QueryFilter\QueryFilterVisitor;
use BusinessLogicLibrary\QueryFilter\QueryFilter;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Test\Bootstrap;

class BookRepositoryTest extends AbstractRepositoryTestCase
{
    /**
     * @var BooksRepository
     */
    private $testedObj;

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
        parent::setUp();

        $this->bookEntityProvider = new BookEntityProvider();

        $this->hydratorMock = $this->getMockBuilder(DoctrineObject::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->classMetadataMock = $this->getMockBuilder(ClassMetadata::class)
            ->setConstructorArgs([BookEntity::class])
            ->setMethods(null)
            ->getMock();

        $fieldNames = [
            'id' => array('columnName' => 'id', 'type' => Type::INTEGER),
            'author' => array('columnName' => 'author', 'type' => Type::STRING),
            'title' => array('columnName' => 'title', 'type' => Type::STRING),
            'year' => array('columnName' => 'year', 'type' => Type::INTEGER),
            'price' => array('columnName' => 'price', 'type' => Type::FLOAT),
            'name' => array('columnName' => 'name', 'type' => Type::STRING),
            'status' => array('columnName' => 'status', 'type' => Type::BOOLEAN)
        ];

        $this->classMetadataMock->fieldMappings = $fieldNames;

        $this->entityManagerMock->expects($this->any())
            ->method('getClassMetadata')
            ->willReturn($this->classMetadataMock);

        $this->testedObj = new BooksRepository($this->entityManagerMock, $this->classMetadataMock);
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

        $testedObj = new BooksRepository($this->entityManagerMock, $this->classMetadataMock);
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

        $testedObj = new BooksRepository($this->entityManagerMock, $this->classMetadataMock);
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

    public function testFindByQueryFilter_WithValidQueryData()
    {
        $sm = Bootstrap::getServiceManager();

        $limit = 5;
        $page = 1;
        $offset = ($page - 1) * $limit;

        $queryData = [
            '$fields' => 'id,author,title',
            '$sort' => '-year,price',
            '$limit' => $limit,
            '$page' => $page,
            'year' => '$between(2014,2005)',
            'price' => [
                '$min(20)',
                '$max(50)'
            ],
            'name' => [
                '$startswith("a")',
                '$endswith("z")',
            ],
            'status' => 'packaging,shipping',
            'author' => '"Robert C. Marting"'
        ];

        /** @var QueryFilter $queryFilter */
        $queryFilter = $sm->get(QueryFilter::class);
        $queryFilter->setQueryParameters($queryData);
        /** @var CommandCollection $commandCollection */
        $commandCollection = $sm->get(CommandCollection::class);

        $queryFilterVisitor = new QueryFilterVisitor($queryFilter, $commandCollection);

        // here we are checking private method that provide us QueryBuilder
        $reflector = new \ReflectionObject($this->testedObj);
        $method = $reflector->getMethod('provideQueryBuilderToFindByQueryFilter');
        $method->setAccessible(true);

        /** @var QueryBuilder $qb */
        $qb = $method->invoke($this->testedObj, $queryFilterVisitor);

        $this->assertSame(
            "SELECT b.id, b.author, b.title FROM BusinessLogicDomainBooks\\Entity\\BookEntity b WHERE (b.year BETWEEN '2005' AND '2014') AND b.price >= '20' AND b.price <= '50' AND b.name LIKE 'a%' AND b.name LIKE '%z' AND b.status IN('packaging', 'shipping') AND b.author = 'Robert C. Marting' ORDER BY b.year desc, b.price asc",
            $this->getRawSQLFromORMQueryBuilder($qb)
        );

        $this->assertSame($offset, $qb->getFirstResult());
        $this->assertSame($limit, $qb->getMaxResults());

        $this->testedObj->findByQueryFilter($queryFilterVisitor);
    }

    public function testFindByQueryFilter_WithNotFoundCriteriaCommand()
    {
        $sm = Bootstrap::getServiceManager();

        $queryData = [
            '$fields' => 'id,author,title',
        ];

        $fieldNames = [
            'id',
            'author',
            'title',
            'year',
            'price',
            'name',
            'status'
        ];

        /** @var QueryFilter $queryFilter */
        $queryFilter = $sm->get(QueryFilter::class);
        $queryFilter->setQueryParameters($queryData);

        $commandCollection = new CommandCollection(
            [
                new BetweenCommand(),
                new OffsetCommand(),
            ]
        );

        $queryFilterVisitor = new QueryFilterVisitor($queryFilter, $commandCollection);

        $this->classMetadataMock->expects($this->any())
            ->method('getFieldNames')
            ->will($this->returnValue($fieldNames));

        $this->setExpectedException(UnsupportedTypeException::class, 'Tried to filter by field "fields" that is not supported');

        $this->testedObj->findByQueryFilter($queryFilterVisitor);
    }

    public function testFindByQueryFilter_WithUnrecognizedField()
    {
        $sm = Bootstrap::getServiceManager();

        $queryData = [
            '$fields' => 'id,author,is_thick_cover',
        ];

        /** @var QueryFilter $queryFilter */
        $queryFilter = $sm->get(QueryFilter::class);
        $queryFilter->setQueryParameters($queryData);

        /** @var CommandCollection $commandCollection */
        $commandCollection = $sm->get(CommandCollection::class);

        $queryFilterVisitor = new QueryFilterVisitor($queryFilter, $commandCollection);

        $this->setExpectedException(UnrecognizedFieldException::class, 'Tried to filter by field "is_thick_cover" which does not exist in entity');

        $this->testedObj->findByQueryFilter($queryFilterVisitor);
    }
}