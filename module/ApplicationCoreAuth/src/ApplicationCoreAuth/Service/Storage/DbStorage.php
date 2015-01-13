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

namespace ApplicationCoreAuth\Service\Storage;

use BusinessLogicDomainUsers\Repository\UsersRepositoryInterface;
use Zend\Authentication\Storage;
use Zend\Authentication\Storage\StorageInterface;

class DbStorage implements StorageInterface
{

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @var UsersRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var mixed
     */
    protected $resolvedIdentity;

    public function __construct(UsersRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @inheritdoc
     */
    public function isEmpty()
    {
        return $this->getStorage()->isEmpty();
    }

    /**
     * @inheritdoc
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
     * @inheritdoc
     */
    public function write($contents)
    {
        $this->resolvedIdentity = null;
        $this->getStorage()->write($contents);
    }

    /**
     * @inheritdoc
     */
    public function clear()
    {
        $this->resolvedIdentity = null;
        $this->getStorage()->clear();
    }

    /**
     * @return StorageInterface
     */
    public function getStorage()
    {
        if (null === $this->storage) {
            $this->setStorage(new Storage\Session);
        }
        return $this->storage;
    }

    /**
     * @param StorageInterface $storage
     * @return self
     */
    public function setStorage(Storage\StorageInterface $storage)
    {
        $this->storage = $storage;

        return $this;
    }

}