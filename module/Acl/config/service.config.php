<?php

return [
    'service_manager' => [
        'invokables' => [
            \Acl\Model\NamesResolver::class => \Acl\Model\NamesResolver::class,
        ],
        'abstract_factories' => [
        ],
        'aliases' => [
        ],
        'factories' => [
            \Acl\Service\AclService::class => \Acl\Service\SLFactory\AclServiceSLFactory::class,
            \Acl\Service\AclFactory::class => \Acl\Service\SLFactory\AclFactorySLFactory::class,
            \Acl\Service\Listener\CheckAccessListener::class => \Acl\Service\Listener\SLFactory\CheckAccessListenerSLFactory::class,
        ],
    ]
];