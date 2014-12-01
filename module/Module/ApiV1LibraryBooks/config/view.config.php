<?php

return [
    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
        'display_not_found_reason' => DEVELOPMENT_ENV ? true : false,
        'display_exceptions' => DEVELOPMENT_ENV ? true : false,
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];