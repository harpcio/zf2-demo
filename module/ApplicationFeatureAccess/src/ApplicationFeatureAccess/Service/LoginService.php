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

namespace ApplicationFeatureAccess\Service;

use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\InputFilter\InputFilterInterface;

class LoginService
{
    /**
     * @var AbstractAdapter
     */
    private $authAdapter;

    /**
     * @var AuthenticationServiceInterface
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