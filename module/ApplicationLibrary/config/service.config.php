<?php

return [
    'service_manager' => [
        'invokables' => [
            \ApplicationLibrary\Logger\Factory\ComponentsFactory::class => \ApplicationLibrary\Logger\Factory\ComponentsFactory::class,
        ],
        'factories' => [
            \ApplicationLibrary\Logger\Manager::class => \ApplicationLibrary\Logger\SLFactory\ManagerSLFactory::class,
            \BusinessLogicLibrary\Pagination\PaginatorInfoFactory::class => \ApplicationLibrary\Pagination\SLFactory\PaginatorInfoFactorySLFactory::class,
            'Logger' => \ApplicationLibrary\Logger\SLFactory\LoggerSLFactory::class,
        ],
    ]
];