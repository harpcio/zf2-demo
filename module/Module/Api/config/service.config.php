<?php

return [
    'service_manager' => [
        'invokables' => [
            \Module\Api\Listener\ResolveExceptionToJsonModelListener::class => \Module\Api\Listener\ResolveExceptionToJsonModelListener::class,
        ],
        'factories' => [
        ],
    ]
];