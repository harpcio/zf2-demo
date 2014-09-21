<?php

use Zend\ServiceManager\ServiceManager;

return [
    'service_manager' => [
        'invokables' => [

        ],
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'aliases' => [
            'translator' => 'MvcTranslator',
        ],
        'factories' => [

        ],
    ]
];