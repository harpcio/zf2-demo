<?php

namespace Auth\Service;

use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\InputFilter\InputFilterInterface;

class LoginService
{
    /**
     * @var AbstractAdapter
     */
    private $authAdapter;

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    public function __construct(
        AuthenticationServiceInterface $authenticationService,
        AbstractAdapter $authenticationAdapter
    ) {
        $this->authenticationService = $authenticationService;
        $this->authAdapter = $authenticationAdapter;
    }

    public function login(InputFilterInterface $filter)
    {
        if (!$filter->isValid()) {
            throw new \LogicException('Form is not valid');
        }

        $this->authAdapter->setIdentity($filter->getValue('login'));
        $this->authAdapter->setCredential($filter->getValue('password'));

        $result = $this->authenticationService->authenticate($this->authAdapter);

        return $result->isValid();
    }

}