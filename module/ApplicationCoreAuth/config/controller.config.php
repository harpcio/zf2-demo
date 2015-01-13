<?php

return [
    'controllers' => [
        'invokables' => [
            'ApplicationCoreAuth\Controller\NoAccess' => \ApplicationCoreAuth\Controller\NoAccessController::class,
        ],
    ],
    'controller_plugins' => [
        'factories' => [
            'identity' => \ApplicationCoreAuth\Controller\Plugin\SLFactory\IdentityControllerPluginSLFactory::class,
        ]
    ]
];