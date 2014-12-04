<?php

namespace BusinessLogic\Users\Entity;

interface UserEntityInterface
{
    const
        ROLE_GUEST = 'guest',
        ROLE_ADMIN = 'admin';

    public function getId();

    public function setName($name);

    public function getName();

    public function setLogin($login);

    public function getLogin();

    public function setPassword($password);

    public function getPassword();

    public function setEmail($email);

    public function getEmail();

    public function setRole($role);

    public function getRole();

}