<?php

namespace Library\Controller\Book;

use Application\Library\QueryFilter\Exception\UnrecognizedFieldException;
use Application\Library\QueryFilter\Exception\UnsupportedTypeException;
use Application\Library\QueryFilter\QueryFilter;
use Library\Service\Book\CrudService;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    /**
     * @var CrudService
     */
    private $service;

    /**
     * @var QueryFilter
     */
    private $queryFilter;

    public function __construct(CrudService $service, QueryFilter $queryFilter)
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