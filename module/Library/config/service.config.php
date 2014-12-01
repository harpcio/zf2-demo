<?php

return [
    'service_manager' => [
        'invokables' => [
            \Library\Logger\Manager::class => \Library\Logger\Manager::class,
        ],
        'factories' => [
            'Logger' => \Library\Logger\Factory\LoggerFactory::class,
            \Library\QueryFilter\QueryFilter::class => \Library\QueryFilter\SLFactory\QueryFilterSLFactory::class,
            \Library\QueryFilter\Command\Repository\CommandCollection::class => \Library\QueryFilter\Command\Repository\SLFactory\CommandCollectionSLFactory::class,
        ],
    ]
];