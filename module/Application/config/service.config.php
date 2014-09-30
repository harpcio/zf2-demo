<?php

return [
    'service_manager' => [
        'invokables' => [
            Application\Logger\Manager::class => Application\Logger\Manager::class,
        ],
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'aliases' => [
            'translator' => 'MvcTranslator',
        ],
        'factories' => [
            'Application\Logger' => Application\Factory\LoggerFactory::class
        ],
    ]
];