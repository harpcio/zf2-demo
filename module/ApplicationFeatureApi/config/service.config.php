<?php

return [
    'service_manager' => [
        'invokables' => [
            \ApplicationFeatureApi\Listener\ResolveExceptionToJsonModelListener::class => \ApplicationFeatureApi\Listener\ResolveExceptionToJsonModelListener::class,
            \ApplicationFeatureApi\Listener\AclIsNotAllowedListener::class => \ApplicationFeatureApi\Listener\AclIsNotAllowedListener::class,
        ],
        'factories' => [
        ],
    ]
];