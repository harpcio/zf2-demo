<?php

namespace Auth\Service\Adapter;

use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NonUniqueResultException;
use User\Entity\UserEntity;
use User\Repository\UserRepositoryInterface;
use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result;
use Zend\Crypt\Password\PasswordInterface;

class DbAdapter extends AbstractAdapter
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var PasswordInterface
     */
    private $crypt;

    public function __construct(UserRepositoryInterface $userRepository, PasswordInterface $crypt)
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