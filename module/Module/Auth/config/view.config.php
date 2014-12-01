<?php

return [
    'view_manager' => [
        'controller_map' => [
            'Module\Auth' => 'auth',
        ],
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ],
    'view_helpers' => [
        'factories' => [
            'identity' => Module\Auth\View\Helper\SLFactory\IdentityViewHelperSLFactory::class,
        ]
    ],
];