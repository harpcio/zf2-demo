<?php

namespace Auth\Controller;

use Auth\Form\LoginForm;
use Auth\Service\LoginService;
use Zend\Mvc\Controller\AbstractActionController;

class LoginController extends AbstractActionController
{
    /**
     * @var LoginForm
     */
    private $form;

    /**
     * @var LoginService
     */
    private $service;

    public function __construct(LoginForm $form, LoginService $service)
    {
        $this->form = $form;
        $this->service = $service;
    }

    public function indexAction()
    {
        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();

        try {
            if ($request->isPost()) {
                $this->form->setData($request->getPost()->toArray() ? : []);
                if ($this->form->isValid()) {
                    if ($this->service->login($this->form->getInputFilter())) {
                        $this->flashMessenger()->addSuccessMessage('User login successfully');
                        return $this->redirect()->toRoute('home');
                    } else {
                        $this->flashMessenger()->addErrorMessage('User name/email or password are incorrect');
                    }
                } else {
                    $this->form->get('password')->setValue(null);
                    $this->flashMessenger()->addErrorMessage('Please fill form correctly');
                }
            }
        } catch (\Exception $e) {
            $this->flashMessenger()->addErrorMessage(
                'An unexpected error has occurred, please contact your system administrator'
            );
        }

        return [
            'form' => $this->form
        ];
    }
}