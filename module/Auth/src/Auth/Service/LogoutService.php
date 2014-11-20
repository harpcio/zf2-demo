<?php

namespace Auth\Service;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\AuthenticationServiceInterface;

class LogoutService
{

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    public function __construct(
        AuthenticationServiceInterface $authenticationService
    ) {
        $this->authenticationService = $authenticationService;
    }

    public function logout()
    {
        $this->authenticationService->clearIdentity();
    }
}