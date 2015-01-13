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