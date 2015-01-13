<?php

return [
    'service_manager' => [
        'invokables' => [
            \ApplicationLibrary\Logger\Factory\ComponentsFactory::class => \ApplicationLibrary\Logger\Factory\ComponentsFactory::class
        ],
        'factories' => [
            'Logger' => \ApplicationLibrary\Logger\SLFactory\LoggerSLFactory::class,
            \ApplicationLibrary\QueryFilter\QueryFilter::class => \ApplicationLibrary\QueryFilter\SLFactory\QueryFilterSLFactory::class,
            \ApplicationLibrary\QueryFilter\Command\Repository\CommandCollection::class => \ApplicationLibrary\QueryFilter\Command\Repository\SLFactory\CommandCollectionSLFactory::class,
            \ApplicationLibrary\Logger\Manager::class => \ApplicationLibrary\Logger\SLFactory\ManagerSLFactory::class,
        ],
    ]
];