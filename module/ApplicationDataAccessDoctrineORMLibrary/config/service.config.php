<?php

return [
    'service_manager' => [
        'invokables' => [
        ],
        'factories' => [
            \BusinessLogicLibrary\QueryFilter\Command\Repository\CommandCollection::class => \ApplicationDataAccessDoctrineORMLibrary\QueryFilter\Command\Repository\SLFactory\CommandCollectionSLFactory::class,
        ],
    ]
];