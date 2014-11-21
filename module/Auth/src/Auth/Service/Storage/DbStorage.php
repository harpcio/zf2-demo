<?php

namespace Auth\Service\Storage;

use User\Repository\UserRepositoryInterface;
use Zend\Authentication\Storage;
use Zend\Authentication\Storage\StorageInterface;

class DbStorage implements StorageInterface
{

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var mixed
     */
    protected $resolvedIdentity;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Returns true if and only if storage is empty
     *
     * @throws \Zend\Authentication\Exception\InvalidArgumentException If it is impossible to determine whether storage is empty
     * @return boolean
     */
    public function isEmpty()
    {
        return $this->getStorage()->isEmpty();
    }

    /**
     * Returns the contents of storage
     *
     * Behavior is undefined when storage is empty.
     *
     * @throws \Zend\Authentication\Exception\InvalidArgumentException If reading contents from storage is impossible
     * @return mixed
     */
    public function read()
    {
        if (null !== $this->resolvedIdentity) {
            return $this->resolvedIdentity;
        }

        $identity = $this->getStorage()->read();

        if (is_int($identity) || is_scalar($identity)) {
            $identity = $this->userRepository->find($identity);
        }

        if ($identity) {
            $this->resolvedIdentity = $identity;
        } else {
            $this->resolvedIdentity = null;
        }

        return $this->resolvedIdentity;
    }

    /**
     * Writes $contents to storage
     *
     * @param  mixed $contents
     *
     * @throws \Zend\Authentication\Exception\InvalidArgumentException If writing $contents to storage is impossible
     * @return void
     */
    public function write($contents)
    {
        $this->resolvedIdentity = null;
        $this->getStorage()->write($contents);
    }

    /**
     * Clears contents from storage
     *
     * @throws \Zend\Authentication\Exception\InvalidArgumentException If clearing contents from storage is impossible
     * @return void
     */
    public function clear()
    {
        $this->resolvedIdentity = null;
        $this->getStorage()->clear();
    }

    /**
     * getStorage
     *
     * @return Storage\StorageInterface
     */
    public function getStorage()
    {
        if (null === $this->storage) {
            $this->setStorage(new Storage\Session);
        }
        return $this->storage;
    }

    /**
     * setStorage
     *
     * @param Storage\StorageInterface $storage
     *
     * @return $this
     */
    public function setStorage(Storage\StorageInterface $storage)
    {
        $this->storage = $storage;

        return $this;
    }

}