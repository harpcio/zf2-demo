<?php

return [
    'controllers' => [
        'invokables' => [
            'Module\Auth\Controller\NoAccess' => \Module\Auth\Controller\NoAccessController::class,
        ],
        'factories' => [
            'Module\Auth\Controller\Login' => \Module\Auth\Controller\SLFactory\LoginControllerSLFactory::class,
            'Module\Auth\Controller\Logout' => \Module\Auth\Controller\SLFactory\LogoutControllerSLFactory::class,
        ],
    ],
    'controller_plugins' => [
        'factories' => [
            'identity' => \Module\Auth\Controller\Plugin\SLFactory\IdentityControllerPluginSLFactory::class,
        ]
    ]
];