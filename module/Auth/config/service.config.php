<?php

return [
    'service_manager' => [
        'invokables' => [
            \Auth\Form\LoginFormInputFilter::class => \Auth\Form\LoginFormInputFilter::class,
        ],
        'abstract_factories' => [
        ],
        'aliases' => [
        ],
        'factories' => [
            \Auth\Form\LoginForm::class => \Auth\Form\SLFactory\LoginFormSLFactory::class,
            \Auth\Service\LoginService::class => \Auth\Service\SLFactory\LoginServiceSLFactory::class,
            \Auth\Service\Storage\DbStorage::class => \Auth\Service\Storage\SLFactory\DbStorageSLFactory::class,
            \Auth\Service\LogoutService::class => \Auth\Service\SLFactory\LogoutServiceSLFactory::class,
            \Auth\Service\Adapter\DbAdapter::class => \Auth\Service\Adapter\SLFactory\DbAdapterSLFactory::class,
        ],
    ]
];