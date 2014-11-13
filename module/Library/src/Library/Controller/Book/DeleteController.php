<?php

namespace Library\Controller\Book;

use Library\Form\DeleteForm;
use Library\Service\Book\CrudService;
use Zend\Mvc\Controller\AbstractActionController;

class DeleteController extends AbstractActionController
{
    /**
     * @var DeleteForm
     */
    private $form;

    /**
     * @var CrudService
     */
    private $service;

    public function __construct(DeleteForm $form, CrudService $service)
    {
        $this->form = $form;
        $this->service = $service;
    }

    public function indexAction()
    {
        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();
        $id = $this->params()->fromRoute('id', null);

        try {
            $bookEntity = $this->service->getById($id);

            if ($request->isPost()) {
                $this->form->setData($request->getPost()->toArray());
                if ($this->form->isValid()) {
                    $this->flashMessenger()->addSuccessMessage('Book deleted successfully');
                    $this->service->delete($bookEntity);

                    return $this->redirect()->toRoute('library/books');
                } else {
                    $this->flashMessenger()->addErrorMessage('Please fill form correctly');
                }
            } else {
                $this->form->get('id')->setValue($bookEntity->getId());
            }

            return [
                'form' => $this->form,
                'book' => $bookEntity
            ];
        } catch (\Exception $e) {
            $this->flashMessenger()->addSuccessMessage($e->getMessage());

            return $this->redirect()->toRoute('library/books');
        }
    }
}