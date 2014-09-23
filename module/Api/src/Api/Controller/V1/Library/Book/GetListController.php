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
        $books = $this->service->getAll();
        $data = [];

        /** @var BookEntity $bookEntity */
        foreach ($books as $bookEntity) {
            $data[] = $this->service->extractEntity($bookEntity);
        }

        return new JsonModel(['data' => $data]);
    }
}