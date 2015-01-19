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

class PaginatorInfoFactory
{
    /**
     * @var int
     */
    protected $itemsPerPage;

    /**
     * @var int
     */
    protected $currentPage;

    /**
     * @var int
     */
    protected $limit;

    public function __construct(array $config)
    {
        $this->itemsPerPage = isset($config['itemsPerPage']) ? $config['itemsPerPage'] : 10;
    }

    /**
     * @param int $numberOfItems
     * @return PaginatorInfo
     * @throws Exception\InvalidArgumentException
     */
    public function create($numberOfItems)
    {
        if (!isset($this->currentPage)) {
            throw new Exception\InvalidArgumentException('Filter params not prepared');
        }

        $itemsPerPage = $this->itemsPerPage;
        $currentPage = $this->currentPage;

        if (!empty($this->limit)) {
            $itemsPerPage = $this->limit;
        }

        return new PaginatorInfo($numberOfItems, $currentPage, $itemsPerPage);
    }

    /**
     * @param array $filterParams
     * @return array
     */
    public function prepareFilterParams(array $filterParams)
    {
        if (isset($filterParams['$page'])) {
            $this->currentPage = (int)$filterParams['$page'];
        } else {
            $this->currentPage = $filterParams['$page'] = 1;
        }

        if (isset($filterParams['$limit'])) {
            $this->limit = (int)$filterParams['$limit'];
        } else {
            $this->limit = $filterParams['$limit'] = $this->itemsPerPage;
        }

        return $filterParams;
    }
}