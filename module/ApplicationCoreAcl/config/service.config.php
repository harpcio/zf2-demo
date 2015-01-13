<?php

return [
    'service_manager' => [
        'invokables' => [
            \ApplicationCoreAcl\Model\NamesResolver::class => \ApplicationCoreAcl\Model\NamesResolver::class,
            \ApplicationCoreAcl\Service\Listener\RouteListener::class => \ApplicationCoreAcl\Service\Listener\RouteListener::class,
        ],
        'abstract_factories' => [
        ],
        'aliases' => [
        ],
        'factories' => [
            \ApplicationCoreAcl\Service\AclService::class => \ApplicationCoreAcl\Service\SLFactory\AclServiceSLFactory::class,
            \ApplicationCoreAcl\Service\AclFactory::class => \ApplicationCoreAcl\Service\SLFactory\AclFactorySLFactory::class,
            \ApplicationCoreAcl\Service\Listener\CheckAccessListener::class => \ApplicationCoreAcl\Service\Listener\SLFactory\CheckAccessListenerSLFactory::class,
        ],
    ]
];