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
            \Application\Listener\Log\LogExceptionListener::class => \Application\Listener\Log\SLFactory\LogExceptionListenerSLFactory::class,
            'navigation' => \Zend\Navigation\Service\DefaultNavigationFactory::class,
        ],
    ]
];