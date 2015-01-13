<?php

return [
    'view_manager' => [
        'controller_map' => [
            'ApplicationFeatureAccess' => 'auth',
        ],
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ],
    'view_helpers' => [
        'factories' => [
        ]
    ],
];