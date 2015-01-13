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

namespace BusinessLogicDomainUsers\Entity;

use BusinessLogicDomainUsers\Repository\UsersRepository;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

class UserEntity implements UserEntityInterface
{
    private $allowedRoles = [
        self::ROLE_ADMIN
    ];

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $login;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $role;

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);
        $builder
            ->setTable('user')
            ->setCustomRepositoryClass(UsersRepository::class);
        $builder->createField('id', Type::INTEGER)->isPrimaryKey()->generatedValue()->build();
        $builder->createField('name', Type::STRING)->length(255)->nullable(false)->build();
        $builder->createField('login', Type::STRING)->length(255)->nullable(false)->build();
        $builder->createField('email', Type::STRING)->length(255)->nullable(false)->build();
        $builder->createField('password', Type::STRING)->length(255)->nullable(false)->build();
        $builder->createField('role', Type::STRING)->length(255)->nullable(false)->build();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $login
     *
     * @return self
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $password
     *
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $role
     *
     * @throws \InvalidArgumentException
     * @return self
     */
    public function setRole($role)
    {
        if (!in_array($role, $this->allowedRoles)) {
            throw new \InvalidArgumentException(sprintf('Role %s not allowed!', $role));
        }

        $this->role = $role;

        return $this;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

}