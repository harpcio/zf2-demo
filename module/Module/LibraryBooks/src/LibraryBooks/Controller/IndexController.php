<?php

namespace Module\LibraryBooks\Controller;

use Library\QueryFilter\Exception\UnrecognizedFieldException;
use Library\QueryFilter\Exception\UnsupportedTypeException;
use Library\QueryFilter\QueryFilter;
use Module\LibraryBooks\Service\FilterResultsService;
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

    public function __construct(FilterResultsService $service, QueryFilter $queryFilter)
    {
        $this->service = $service;
        $this->queryFilter = $queryFilter;
    }

    public function indexAction()
    {
        $books = [];

        try {
            $this->queryFilter->setQueryParameters($this->params()->fromQuery());

            $books = $this->service->getFilteredResults($this->queryFilter);
        } catch (UnrecognizedFieldException $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        } catch (UnsupportedTypeException $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return [
            'books' => $books
        ];
    }
}