<?php

namespace Library\Controller\Book;

use Library\Form\Book\CreateForm;
use Library\Service\Book\CrudService;
use Zend\Mvc\Controller\AbstractActionController;

class CreateController extends AbstractActionController
{
    /**
     * @var CreateForm
     */
    private $form;

    /**
     * @var CrudService
     */
    private $service;

    public function __construct(CreateForm $form, CrudService $service)
    {
        $this->form    = $form;
        $this->service = $service;
    }

    public function indexAction()
    {
        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();
        try {
            $this->form->get('submit')->setValue('Create');

            if ($request->isPost()) {
                $this->form->setData($request->getPost()->toArray() ? : []);
                if ($this->form->isValid()) {
                    $bookEntity = $this->service->create($this->form->getInputFilter());
                    $this->flashMessenger()->addSuccessMessage('Book saved successfully!');

                    return $this->redirect()->toRoute('library/book/update', ['id' => $bookEntity->getId()]);
                } else {
                    $this->flashMessenger()->addErrorMessage('Please fill form correctly');
                }
            }
        } catch (\Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return [
            'form' => $this->form ? : null
        ];
    }

}