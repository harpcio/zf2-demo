<?php

namespace Module\LibraryBooksTest\Service;

use BusinessLogic\BooksTest\Entity\Provider\BookEntityProvider;
use Library\QueryFilter\QueryFilter;
use Library\QueryFilter\Command\Repository\CommandCollection;
use BusinessLogic\Books\Repository\BooksRepositoryInterface;
use Module\LibraryBooks\Service\FilterResultsService;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class FilterResultsServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FilterResultsService
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

        $this->bookRepositoryMock = $this->getMock(BooksRepositoryInterface::class);

        $this->testedObj = new FilterResultsService(
            $this->bookRepositoryMock,
            new CommandCollection([])
        );
    }

    public function testGetFilteredResult()
    {
        $bookEntity1 = $this->bookEntityProvider->getBookEntityWithRandomData();
        $bookEntity2 = $this->bookEntityProvider->getBookEntityWithRandomData();

        $books = [$bookEntity1, $bookEntity2];

        $this->bookRepositoryMock->expects($this->once())
            ->method('findByQueryFilter')
            ->will($this->returnValue($books));

        $result = $this->testedObj->getFilteredResults(new QueryFilter([], []));

        $this->assertSame($books, $result);
    }
}