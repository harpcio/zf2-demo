<?php

return [
    'service_manager' => [
        'invokables' => [
            \ApplicationFeatureLibraryBooks\Form\CreateFormInputFilter::class => \ApplicationFeatureLibraryBooks\Form\CreateFormInputFilter::class,
            \ApplicationFeatureLibraryBooks\Form\DeleteFormInputFilter::class => \ApplicationFeatureLibraryBooks\Form\DeleteFormInputFilter::class,
        ],
        'abstract_factories' => [
        ],
        'aliases' => [
        ],
        'factories' => [
            \ApplicationFeatureLibraryBooks\Form\CreateForm::class => \ApplicationFeatureLibraryBooks\Form\SLFactory\CreateFormSLFactory::class,
            \ApplicationFeatureLibraryBooks\Form\DeleteForm::class => \ApplicationFeatureLibraryBooks\Form\SLFactory\DeleteFormSLFactory::class,
            \ApplicationFeatureLibraryBooks\Service\CrudService::class => \ApplicationFeatureLibraryBooks\Service\SLFactory\CrudServiceSLFactory::class,
            \ApplicationFeatureLibraryBooks\Service\FilterResultsService::class => \ApplicationFeatureLibraryBooks\Service\SLFactory\FilterResultsServiceSLFactory::class,
        ],
    ]
];