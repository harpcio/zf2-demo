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

namespace BusinessLogicLibrary\Pagination;

class PaginatorInfo
{
    const SHOWING_TEXT_PATTERN = 'Showing %s to %s of %s items';

    /**
     * @var int
     */
    protected $nextPage;

    /**
     * @var int
     */
    protected $previousPage;

    /**
     * @var int
     */
    protected $firstPage;

    /**
     * @var int
     */
    protected $lastPage;

    /**
     * @var int
     */
    protected $currentPage;

    /**
     * @var array
     */
    protected $pagesToShow = array();

    /**
     * @var int
     */
    protected $numberOfPages;

    /**
     * @var int
     */
    protected $itemsPerPage;

    /**
     * @var int
     */
    protected $numberOfItems;

    /**
     * @var string
     */
    protected $showingText;

    /**
     * @param int $numberOfItems
     * @param int $currentPage
     * @param int $itemsPerPage
     * @throws Exception\InvalidArgumentException
     */
    public function __construct($numberOfItems, $currentPage, $itemsPerPage)
    {
        $this->setNumberOfItems($numberOfItems);
        $this->setItemsPerPage($itemsPerPage);
        $this->calculateNumberOfPages();
        $this->setCurrentPage($currentPage);
        $this->checkIfCurrentPageIsNotGreaterThanNumberOfPages();
        $this->prepareNavigationPages();
        $this->prepareShowingText();
    }

    /**
     * @throws Exception\InvalidArgumentException
     */
    protected function checkIfCurrentPageIsNotGreaterThanNumberOfPages()
    {
        if ($this->currentPage > $this->numberOfPages && !empty($this->numberOfPages)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Current page must be greater than or equal to "1" or less than or equal to "%s"',
                $this->numberOfPages
            ));
        }
    }

    protected function prepareNavigationPages()
    {
        $this->firstPage = 1;
        $this->nextPage = $this->currentPage + 1;
        $this->previousPage = $this->currentPage - 1;
        $this->lastPage = $this->numberOfPages;

        if ($this->previousPage < 1) {
            $this->previousPage = 1;
        }

        if ($this->nextPage > $this->numberOfPages) {
            $this->nextPage = $this->numberOfPages;
        }
    }

    protected function prepareShowingText()
    {
        $currentPageFirstItem = (($this->currentPage - 1) * $this->itemsPerPage) + 1;

        if ($this->currentPage === $this->lastPage) {
            $currentPageLastItem = $this->numberOfItems;
        } else {
            $currentPageLastItem = $this->currentPage * $this->itemsPerPage;
        }

        $this->showingText = sprintf(
            self::SHOWING_TEXT_PATTERN,
            $currentPageFirstItem,
            $currentPageLastItem,
            $this->numberOfItems
        );
    }

    /**
     * @param int $howManyShowPages
     * @throws Exception\InvalidArgumentException
     */
    public function preparePagesToShow($howManyShowPages = 5)
    {
        $howManyShowPages = (int)$howManyShowPages;

        if (empty($howManyShowPages)) {
            throw new Exception\InvalidArgumentException('Argument $howManyShowPages cannot be empty');
        }

        $this->pagesToShow[] = $this->currentPage;

        $items = 1;
        $i = 1;
        while ($items < $howManyShowPages) {
            if ($this->currentPage - $i < 1) {
                if ($this->currentPage + $i > $this->numberOfPages) {
                    break;
                }
            } else {
                $this->pagesToShow[] = $this->currentPage - $i;
                $items = $items + 1;
            }

            if ($this->currentPage + $i <= $this->numberOfPages) {
                $this->pagesToShow[] = $this->currentPage + $i;
                $items = $items + 1;
            }

            $i = $i + 1;
        }

        sort($this->pagesToShow);
    }

    /**
     * @return int
     */
    public function getNextPage()
    {
        return $this->nextPage;
    }

    /**
     * @return int
     */
    public function getPreviousPage()
    {
        return $this->previousPage;
    }

    /**
     * @return int
     */
    public function getFirstPage()
    {
        return $this->firstPage;
    }

    /**
     * @return int
     */
    public function getLastPage()
    {
        return $this->lastPage;
    }

    /**
     * @param int $currentPage
     * @throws Exception\InvalidArgumentException
     */
    protected function setCurrentPage($currentPage)
    {
        $currentPage = (int)$currentPage;

        if ($currentPage < 1) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Current page must be greater than or equal to "1" or less than or equal to "%s"',
                $this->numberOfPages
            ));
        }

        $this->currentPage = $currentPage;
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * @return array
     */
    public function getPagesToShow()
    {
        return $this->pagesToShow;
    }

    protected function calculateNumberOfPages()
    {
        $this->numberOfPages = (int)ceil($this->numberOfItems / $this->itemsPerPage);
    }

    /**
     * @return int
     */
    public function getNumberOfPages()
    {
        return $this->numberOfPages;
    }

    /**
     * @param int $itemsPerPage
     * @throws Exception\InvalidArgumentException
     */
    protected function setItemsPerPage($itemsPerPage)
    {
        $itemsPerPage = (int)$itemsPerPage;

        if (empty($itemsPerPage)) {
            throw new Exception\InvalidArgumentException('Items per page cannot be empty');
        }

        $this->itemsPerPage = $itemsPerPage;
    }

    /**
     * @return int
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * @param int $numberOfItems
     */
    protected function setNumberOfItems($numberOfItems)
    {
        $this->numberOfItems = (int)$numberOfItems;
    }

    /**
     * @return int
     */
    public function getNumberOfItems()
    {
        return $this->numberOfItems;
    }

    /**
     * @return string
     */
    public function getShowingText()
    {
        return $this->showingText;
    }

    /**
     * @return bool
     */
    public function shouldDisplay()
    {
        return $this->numberOfPages > 1;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = array(
            'firstPage' => $this->getFirstPage(),
            'previousPage' => $this->getPreviousPage(),
            'currentPage' => $this->getCurrentPage(),
            'nextPage' => $this->getNextPage(),
            'lastPage' => $this->getLastPage(),
            'itemsPerPage' => $this->getItemsPerPage(),
            'numberOfPages' => $this->getNumberOfPages(),
            'numberOfItems' => $this->getNumberOfItems(),
            'showingText' => $this->getShowingText()
        );

        if (!empty($this->getPagesToShow())) {
            $data['pagesToShow'] = $this->getPagesToShow();
        }

        return $data;
    }
}