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
            \BusinessLogicDomainBooks\Repository\BooksRepository::class => \BusinessLogicDomainBooks\Repository\SLFactory\BooksRepositorySLFactory::class,
        ],
    ]
];