<?php

return [
    'service_manager' => [
        'invokables' => [
            \Module\Auth\Form\LoginFormInputFilter::class => \Module\Auth\Form\LoginFormInputFilter::class,
        ],
        'abstract_factories' => [
        ],
        'aliases' => [
        ],
        'factories' => [
            \Module\Auth\Form\LoginForm::class => \Module\Auth\Form\SLFactory\LoginFormSLFactory::class,
            \Module\Auth\Service\LoginService::class => \Module\Auth\Service\SLFactory\LoginServiceSLFactory::class,
            \Module\Auth\Service\Storage\DbStorage::class => \Module\Auth\Service\Storage\SLFactory\DbStorageSLFactory::class,
            \Module\Auth\Service\LogoutService::class => \Module\Auth\Service\SLFactory\LogoutServiceSLFactory::class,
            \Module\Auth\Service\Adapter\DbAdapter::class => \Module\Auth\Service\Adapter\SLFactory\DbAdapterSLFactory::class,
            \Zend\Authentication\AuthenticationService::class => \Module\Auth\Service\SLFactory\AuthenticationServiceSLFactory::class,
        ],
    ]
];