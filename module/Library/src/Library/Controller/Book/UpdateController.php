<?php

namespace Library\Controller\Book;

use Doctrine\ORM\EntityNotFoundException;
use Library\Form\Book\CreateForm;
use Library\Service\Book\CrudService;
use Zend\Mvc\Controller\AbstractActionController;

class UpdateController extends AbstractActionController
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
        $id      = $this->params()->fromRoute('id', null);

        try {
            $bookEntity = $this->service->getById($id);
            $this->form->get('submit')->setValue('Update');

            if ($request->isPost()) {
                $this->form->setData($request->getPost()->toArray() ? : []);
                if ($this->form->isValid()) {
                    $this->service->update($bookEntity, $this->form->getInputFilter());
                    $this->flashMessenger()->addSuccessMessage('Book saved successfully!');
                } else {
                    $this->flashMessenger()->addErrorMessage('Please fill form correctly');
                }
            } else {
                $data = $this->service->hydrateEntity($bookEntity);
                $this->form->setData($data);
            }
        } catch (EntityNotFoundException $e) {
            $this->flashMessenger()->addErrorMessage(sprintf('Cannot find book by id "%s"!', $id));

            return $this->redirect()->toRoute('library/book');
        } catch (\Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return [
            'form' => $this->form ? : null,
        ];
    }

}