<?php

return [
    'view_manager' => [
    ],
    'view_helpers' => [
        'invokables' => [
            'IsAllowed' => \Acl\View\Helper\IsAllowed::class,
        ]
    ],
];