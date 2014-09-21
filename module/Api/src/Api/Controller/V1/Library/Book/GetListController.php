<?php

namespace Api\Controller\V1\Library\Book;

use Library\Entity\BookEntity;
use Library\Service\Book\CrudService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class GetListController extends AbstractActionController
{

    /**
     * @var CrudService
     */
    private $service;

    public function __construct(CrudService $service)
    {
        $this->service = $service;
    }

    public function indexAction()
    {
        $books = $this->service->getBooks();
        $data  = [];

        /** @var BookEntity $book */
        foreach ($books as $book) {
            $data[] = [
                'id'          => $book->getId(),
                'title'       => $book->getTitle(),
                'description' => $book->getDescription(),
                'isbn'        => $book->getIsbn(),
                'year'        => $book->getYear(),
                'publisher'   => $book->getPublisher(),
                'price'       => $book->getPrice()
            ];
        }

        return new JsonModel(['data' => $data]);
    }
}