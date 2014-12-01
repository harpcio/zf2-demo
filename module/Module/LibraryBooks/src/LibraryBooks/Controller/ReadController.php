<?php

namespace Module\LibraryBooks\Controller;

use Module\LibraryBooks\Service\CrudService;
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

            return $this->redirect()->toRoute('library/books');
        }

        return [
            'book' => $bookEntity,
        ];
    }
}