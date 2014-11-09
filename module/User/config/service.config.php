<?php

use Zend\ServiceManager\ServiceManager;

return [
    'service_manager' => [
        'invokables' => [
        ],
        'abstract_factories' => [
        ],
        'aliases' => [
        ],
        'factories' => [
            \User\Repository\UserRepository::class => function (ServiceManager $sm) {
                    $em = $sm->get(\Doctrine\ORM\EntityManager::class);
                    return $em->getRepository(\User\Entity\UserEntity::class);
                }
        ],
    ]
];