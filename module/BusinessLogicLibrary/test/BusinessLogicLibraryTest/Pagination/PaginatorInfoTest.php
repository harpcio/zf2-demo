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

namespace BusinessLogicLibraryTest\Pagination;

use BusinessLogicLibrary\Pagination\PaginatorInfo;

class PaginatorInfoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PaginatorInfo
     */
    private $testedObject;

    /**
     * @var int
     */
    private $numberOfItems;

    /**
     * @var int
     */
    private $currentPage;

    /**
     * @var int
     */
    private $itemsPerPage;

    public function setUp()
    {
        $this->numberOfItems = 100;
        $this->currentPage = 5;
        $this->itemsPerPage = 10;
        $this->testedObject = new PaginatorInfo(
            $this->numberOfItems, $this->currentPage, $this->itemsPerPage
        );
    }

    public function testInstance()
    {
        $this->assertSame($this->numberOfItems, $this->testedObject->getNumberOfItems());
        $this->assertSame($this->itemsPerPage, $this->testedObject->getItemsPerPage());

        $this->assertSame(10, $this->testedObject->getNumberOfPages());

        $this->assertSame($this->currentPage, $this->testedObject->getCurrentPage());
        $this->assertSame(1, $this->testedObject->getFirstPage());
        $this->assertSame($this->currentPage - 1, $this->testedObject->getPreviousPage());
        $this->assertSame($this->currentPage + 1, $this->testedObject->getNextPage());
        $this->assertSame(10, $this->testedObject->getLastPage());

        $this->assertSame('Showing 41 to 50 of 100 items', $this->testedObject->getShowingText());

        $expected = [
            'firstPage' => 1,
            'previousPage' => 4,
            'currentPage' => 5,
            'nextPage' => 6,
            'lastPage' => 10,
            'itemsPerPage' => 10,
            'numberOfPages' => 10,
            'numberOfItems' => 100,
            'showingText' => 'Showing 41 to 50 of 100 items',
        ];

        $this->assertSame($expected, $this->testedObject->toArray());
    }

    public function testPreparePagesToShow()
    {
        $this->testedObject->preparePagesToShow(7);

        $this->assertSame([2, 3, 4, 5, 6, 7, 8], $this->testedObject->getPagesToShow());

        $expected = [
            'firstPage' => 1,
            'previousPage' => 4,
            'currentPage' => 5,
            'nextPage' => 6,
            'lastPage' => 10,
            'itemsPerPage' => 10,
            'numberOfPages' => 10,
            'numberOfItems' => 100,
            'showingText' => 'Showing 41 to 50 of 100 items',
            'pagesToShow' =>
                array(
                    0 => 2,
                    1 => 3,
                    2 => 4,
                    3 => 5,
                    4 => 6,
                    5 => 7,
                    6 => 8,
                ),
        ];

        $this->assertSame($expected, $this->testedObject->toArray());
    }
}