<?php

namespace Library\Controller\Book;

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
        $this->queryFilter->setQuery($this->params()->fromQuery());

        $books = $this->service->getFilteredResults($this->queryFilter);

        return [
            'books' => $books
        ];
    }
}