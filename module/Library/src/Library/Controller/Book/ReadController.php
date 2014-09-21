<?php

namespace Library\Controller\Book;

use Library\Service\Book\CrudService;
use Zend\Mvc\Controller\AbstractActionController;

class ReadController extends AbstractActionController
{
    public function __construct(CrudService $service)
    {
        $this->service = $service;
    }

    public function indexAction()
    {
        $id = $this->params()->fromRoute('id', null);

        try {
            $bookEntity = $this->service->getById($id);
        } catch (\Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());

            return $this->redirect()->toRoute('library/book');
        }

        return [
            'book' => $bookEntity,
        ];
    }
}