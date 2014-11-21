<?php

use Zend\ServiceManager\ServiceManager;

return [
    'controllers' => [
        'invokables' => [
        ],
        'factories' => [
            'Auth\Controller\Login' => \Auth\Controller\SLFactory\LoginControllerSLFactory::class,
            'Auth\Controller\Logout' => \Auth\Controller\SLFactory\LogoutControllerSLFactory::class,
        ],
    ],
    'controller_plugins' => [
        'factories' => [
            'identity' => function (ServiceManager $sm) {
                    /** @var \Auth\Service\Storage\DbStorage $storage */
                    $storage = $sm->get(\Auth\Service\Storage\DbStorage::class);
                    $authentication = new \Zend\Authentication\AuthenticationService($storage);

                    $identity = new \Zend\Mvc\Controller\Plugin\Identity();
                    $identity->setAuthenticationService($authentication);

                    return $identity;
                }
        ]
    ]
];