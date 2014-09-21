<?php

namespace Api\Controller\V1\Library\Book;

use Api\Exception;
use Library\Service\Book\CrudService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class GetController extends AbstractActionController
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
        $id = $this->params()->fromRoute('id', null);

        try {
            $book = $this->service->getById($id);

            $data = [
                'id'          => $book->getId(),
                'title'       => $book->getTitle(),
                'description' => $book->getDescription(),
                'isbn'        => $book->getIsbn(),
                'year'        => $book->getYear(),
                'publisher'   => $book->getPublisher(),
                'price'       => $book->getPrice()
            ];

            return new JsonModel($data);
        } catch (\Exception $e) {
            throw new Exception\NotFoundException();
        }
    }
}