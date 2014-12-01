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
            \Acl\Service\CheckAclService::class => \Acl\Service\SLFactory\CheckAclServiceSLFactory::class,
            \Acl\Service\AclFactory::class => \Acl\Service\SLFactory\AclFactorySLFactory::class
        ],
    ]
];