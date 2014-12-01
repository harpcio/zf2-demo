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
            \BusinessLogic\Users\Repository\UsersRepository::class => \BusinessLogic\Users\Repository\SLFactory\UsersRepositorySLFactory::class,
        ],
    ]
];