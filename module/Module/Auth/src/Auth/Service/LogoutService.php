<?php

namespace Module\Auth\Service;

use Zend\Authentication\AuthenticationServiceInterface;

class LogoutService
{

    /**
     * @var AuthenticationServiceInterface
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