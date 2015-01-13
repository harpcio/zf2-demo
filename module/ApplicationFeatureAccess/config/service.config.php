<?php

return [
    'service_manager' => [
        'invokables' => [
            \ApplicationFeatureAccess\Form\LoginFormInputFilter::class => \ApplicationFeatureAccess\Form\LoginFormInputFilter::class,
        ],
        'abstract_factories' => [
        ],
        'aliases' => [
        ],
        'factories' => [
            \ApplicationFeatureAccess\Form\LoginForm::class => \ApplicationFeatureAccess\Form\SLFactory\LoginFormSLFactory::class,
            \ApplicationFeatureAccess\Service\LoginService::class => \ApplicationFeatureAccess\Service\SLFactory\LoginServiceSLFactory::class,
            \ApplicationFeatureAccess\Service\LogoutService::class => \ApplicationFeatureAccess\Service\SLFactory\LogoutServiceSLFactory::class,
        ],
    ]
];