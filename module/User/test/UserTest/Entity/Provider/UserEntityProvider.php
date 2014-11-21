<?php

namespace UserTest\Entity\Provider;

use Test\Bootstrap;
use User\Entity\UserEntity;

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

        extract($params);

        $userEntity = new UserEntity();
        $userEntity->setName($name)
            ->setEmail($email)
            ->setLogin($login)
            ->setPassword($password);

        if ($withId) {
            Bootstrap::setIdToEntity($userEntity, $entityId);
        }

        return $userEntity;
    }
}