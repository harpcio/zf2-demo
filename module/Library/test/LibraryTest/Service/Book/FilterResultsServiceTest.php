<?php

namespace LibraryTest\Service\Book;

use Application\Library\QueryFilter\QueryFilter;
use Application\Library\QueryFilter\Command\Repository\CommandCollection;
use Library\Repository\BookRepositoryInterface;
use Library\Service\Book\FilterResultsService;
use LibraryTest\Entity\Provider\BookEntityProvider;
use PHPUnit_Framework_Comparator_MockObject as MockObject;

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

        $this->bookRepositoryMock = $this->getMock(BookRepositoryInterface::class);

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