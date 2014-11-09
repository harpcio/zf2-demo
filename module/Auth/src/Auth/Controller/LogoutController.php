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
        $this->service->logout();

        $this->redirect()->toRoute('home');
    }
}