<?php

namespace Auth\Controller;

use Auth\Service\LogoutService;
use Zend\Mvc\Controller\AbstractActionController;

class LogoutController extends AbstractActionController
{
    /**
     * @var LogoutService
     */
    private $service;

    public function __construct(LogoutService $service)
    {
        $this->service = $service;
    }

    public function indexAction()
    {
        try {
            $this->service->logout();

            return $this->redirect()->toRoute('home');
        } catch (\Exception $e) {
            return $this->flashMessenger()->addErrorMessage(
                'An unexpected error has occurred, please contact your system administrator'
            );
        }
    }
}