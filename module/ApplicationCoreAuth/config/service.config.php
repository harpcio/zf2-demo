<?php

return [
    'service_manager' => [
        'invokables' => [
        ],
        'abstract_factories' => [
        ],
        'aliases' => [
        ],
        'factories' => [
            \ApplicationCoreAuth\Service\Storage\DbStorage::class => \ApplicationCoreAuth\Service\Storage\SLFactory\DbStorageSLFactory::class,
            \ApplicationCoreAuth\Service\Adapter\DbAdapter::class => \ApplicationCoreAuth\Service\Adapter\SLFactory\DbAdapterSLFactory::class,
            \Zend\Authentication\AuthenticationService::class => \ApplicationCoreAuth\Service\SLFactory\AuthenticationServiceSLFactory::class,
        ],
    ]
];