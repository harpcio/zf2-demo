<?php

return [
    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
        'display_not_found_reason' => false,
        'display_exceptions' => false,
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];