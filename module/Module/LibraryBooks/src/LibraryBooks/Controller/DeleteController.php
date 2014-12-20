<?php
/**
 * This file is part of Zf2-demo package
 *
 * @author Rafal Ksiazek <harpcio@gmail.com>
 * @copyright Rafal Ksiazek F.H.U. Studioars
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Module\LibraryBooks\Controller;

use Module\LibraryBooks\Form\DeleteForm;
use Module\LibraryBooks\Service\CrudService;
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
                    $this->flashMessenger()->addSuccessMessage('Books deleted successfully');
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