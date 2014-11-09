<?php

namespace Auth\Service;

use Auth\Adapter\DbAdapter;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\InputFilter\InputFilterInterface;

class LoginService
{
    /**
     * @var DbAdapter
     */
    private $authAdapter;

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    public function __construct(
        AuthenticationServiceInterface $authenticationService,
        AdapterInterface $authenticationAdapter
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