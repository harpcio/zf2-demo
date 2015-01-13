<?php

return [
    'service_manager' => [
        'invokables' => [
        ],
        'abstract_factories' => [
        ],
        'aliases' => [
        ],
        'factories' => [
            \ApplicationCoreLang\Model\LangConfig::class => \ApplicationCoreLang\Model\SLFactory\LangConfigSLFactory::class,
            \ApplicationCoreLang\Listener\Lang\LangListener::class => \ApplicationCoreLang\Listener\Lang\SLFactory\LangListenerSLFactory::class,
            \ApplicationCoreLang\Listener\Lang\LangRecognizer::class => \ApplicationCoreLang\Listener\Lang\SLFactory\LangRecognizerSLFactory::class,
            \ApplicationCoreLang\Listener\Lang\LangRedirector::class => \ApplicationCoreLang\Listener\Lang\SLFactory\LangRedirectorSLFactory::class,
        ],
    ]
];