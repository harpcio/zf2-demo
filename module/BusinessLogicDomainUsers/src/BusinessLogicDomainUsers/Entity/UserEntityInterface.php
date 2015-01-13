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