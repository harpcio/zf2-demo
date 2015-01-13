<?php

return [
    'controllers' => [
        'invokables' => [
        ],
        'factories' => [
            'ApplicationFeatureAccess\Controller\Login' => \ApplicationFeatureAccess\Controller\SLFactory\LoginControllerSLFactory::class,
            'ApplicationFeatureAccess\Controller\Logout' => \ApplicationFeatureAccess\Controller\SLFactory\LogoutControllerSLFactory::class,
        ],
    ],
    'controller_plugins' => [
        'factories' => [
        ]
    ]
];