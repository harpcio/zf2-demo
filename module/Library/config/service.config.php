<?php

return [
    'service_manager' => [
        'invokables' => [
            \Library\Logger\Factory\ComponentsFactory::class => \Library\Logger\Factory\ComponentsFactory::class
        ],
        'factories' => [
            'Logger' => \Library\Logger\SLFactory\LoggerSLFactory::class,
            \Library\QueryFilter\QueryFilter::class => \Library\QueryFilter\SLFactory\QueryFilterSLFactory::class,
            \Library\QueryFilter\Command\Repository\CommandCollection::class => \Library\QueryFilter\Command\Repository\SLFactory\CommandCollectionSLFactory::class,
            \Library\Logger\Manager::class => \Library\Logger\SLFactory\ManagerSLFactory::class,
        ],
    ]
];