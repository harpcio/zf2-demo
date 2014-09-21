<?php

namespace Library\Controller\Book;

use Library\Service\Book\CrudService;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    public function __construct(CrudService $service)
    {
        $this->service = $service;
    }

    public function indexAction()
    {
        $books = $this->service->getBooks();

        return [
            'books' => $books
        ];
    }
}