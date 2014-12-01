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
            \BusinessLogic\Books\Repository\BooksRepository::class => \BusinessLogic\Books\Repository\SLFactory\BooksRepositorySLFactory::class,
        ],
    ]
];