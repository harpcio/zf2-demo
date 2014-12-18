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
            \Application\Model\LangConfig::class => \Application\Model\SLFactory\LangConfigSLFactory::class,
            \Application\Listener\Lang\LangListener::class => \Application\Listener\Lang\SLFactory\LangListenerSLFactory::class,
            \Application\Listener\Lang\LangRecognizer::class => \Application\Listener\Lang\SLFactory\LangRecognizerSLFactory::class,
            \Application\Listener\Lang\LangRedirector::class => \Application\Listener\Lang\SLFactory\LangRedirectorSLFactory::class,
            \Application\Listener\Log\LogExceptionListener::class => \Application\Listener\Log\SLFactory\LogExceptionListenerSLFactory::class,
            'navigation' => \Zend\Navigation\Service\DefaultNavigationFactory::class,
        ],
    ]
];