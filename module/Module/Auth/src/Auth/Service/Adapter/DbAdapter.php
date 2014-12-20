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

namespace Module\Auth\Service\Adapter;

use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NonUniqueResultException;
use BusinessLogic\Users\Entity\UserEntity;
use BusinessLogic\Users\Repository\UsersRepositoryInterface;
use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result;
use Zend\Crypt\Password\PasswordInterface;

class DbAdapter extends AbstractAdapter
{
    /**
     * @var UsersRepositoryInterface
     */
    private $userRepository;

    /**
     * @var PasswordInterface
     */
    private $crypt;

    public function __construct(UsersRepositoryInterface $userRepository, PasswordInterface $crypt)
    {
        $this->userRepository = $userRepository;
        $this->crypt = $crypt;
    }

    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface If authentication cannot be performed
     */
    public function authenticate()
    {
        try {
            /** @var UserEntity $user */
            $user = $this->userRepository->findOneBy(['login' => $this->getIdentity()]);
        } catch (EntityNotFoundException $e) {
            return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, null);
        } catch (NonUniqueResultException $e) {
            return new Result(Result::FAILURE_IDENTITY_AMBIGUOUS, null);
        }

        if ($user && $this->crypt->verify($this->getCredential(), $user->getPassword())) {
            return new Result(Result::SUCCESS, $user->getId());
        }

        return new Result(Result::FAILURE_CREDENTIAL_INVALID, null);
    }
}