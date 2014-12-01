<?php

namespace BusinessLogic\UsersTest\Entity\Provider;

use Test\Bootstrap;
use BusinessLogic\Users\Entity\UserEntity;
use BusinessLogic\Users\Entity\UserEntityInterface;

class UserEntityProvider
{
    /**
     * @param array $params
     *
     * @return UserEntity
     */
    public static function createEntityWithRandomData(array $params = [])
    {
        $withId = true;
        $entityId = mt_rand(1, 999);

        $name = uniqid('name');
        $email = uniqid('email');
        $login = uniqid('login');
        $password = uniqid('password');
        $role = UserEntityInterface::ROLE_ADMIN;

        extract($params);

        $userEntity = new UserEntity();
        $userEntity->setName($name)
            ->setEmail($email)
            ->setLogin($login)
            ->setPassword($password)
            ->setRole($role);

        if ($withId) {
            Bootstrap::setIdToEntity($userEntity, $entityId);
        }

        return $userEntity;
    }
}