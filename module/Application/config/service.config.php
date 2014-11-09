<?php

return [
    'service_manager' => [
        'invokables' => [
            \Application\Library\Logger\Manager::class => \Application\Library\Logger\Manager::class,
        ],
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'aliases' => [
            'translator' => 'MvcTranslator',
        ],
        'factories' => [
            'Application\Logger' => \Application\Library\Logger\Factory\LoggerFactory::class
        ],
    ]
];