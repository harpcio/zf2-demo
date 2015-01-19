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

namespace ApplicationFeatureLibraryBooks\Controller;

use ApplicationFeatureLibraryBooks\Service\FilterResultsService;
use BusinessLogicLibrary\Pagination\Exception\PaginationException;
use BusinessLogicLibrary\Pagination\PaginatorAdapter;
use BusinessLogicLibrary\Pagination\PaginatorInfoFactory;
use BusinessLogicLibrary\QueryFilter\Exception\QueryFilterException;
use BusinessLogicLibrary\QueryFilter\QueryFilter;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    /**
     * @var FilterResultsService
     */
    private $service;

    /**
     * @var QueryFilter
     */
    private $queryFilter;

    /**
     * @var PaginatorInfoFactory
     */
    private $paginatorInfoFactory;

    public function __construct(
        FilterResultsService $service,
        QueryFilter $queryFilter,
        PaginatorInfoFactory $paginatorInfoFactory
    ) {
        $this->service = $service;
        $this->queryFilter = $queryFilter;
        $this->paginatorInfoFactory = $paginatorInfoFactory;
    }

    public function indexAction()
    {
        try {
            $filterParams = $this->paginatorInfoFactory->prepareFilterParams($this->params()->fromQuery());
            $this->queryFilter->setQueryParameters($filterParams);

            /** @var PaginatorAdapter $paginator */
            $paginator = $this->service->getFilteredResults($this->queryFilter);
            $paginatorInfo = $this->paginatorInfoFactory->create($paginator->count());
            $paginatorInfo->preparePagesToShow();

            return [
                'books' => $paginator->getIterator(),
                'paginator' => $paginatorInfo,
                'route' => 'library/books/*', // this should go to paginator view helper
                'query' => $filterParams
            ];
        } catch (QueryFilterException $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        } catch (PaginationException $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return array('books' => array());
    }
}