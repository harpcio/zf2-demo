<?php

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
            \Application\Service\Listener\LogExceptionListener::class => \Application\Service\Listener\SLFactory\LogExceptionListenerSLFactory::class,
        ],
    ]
];