<?php

return [
    'view_manager' => [
    ],
    'view_helpers' => [
        'invokables' => [
            'IsAllowed' => \ApplicationCoreAcl\View\Helper\IsAllowed::class,
        ]
    ],
];