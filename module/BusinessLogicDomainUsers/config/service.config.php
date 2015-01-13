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
            \BusinessLogicDomainUsers\Repository\UsersRepository::class => \BusinessLogicDomainUsers\Repository\SLFactory\UsersRepositorySLFactory::class,
        ],
    ]
];