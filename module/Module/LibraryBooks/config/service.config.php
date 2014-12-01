<?php

return [
    'service_manager' => [
        'invokables' => [
            \Module\LibraryBooks\Form\CreateFormInputFilter::class => \Module\LibraryBooks\Form\CreateFormInputFilter::class,
            \Module\LibraryBooks\Form\DeleteFormInputFilter::class => \Module\LibraryBooks\Form\DeleteFormInputFilter::class,
        ],
        'abstract_factories' => [
        ],
        'aliases' => [
        ],
        'factories' => [
            \Module\LibraryBooks\Form\CreateForm::class => \Module\LibraryBooks\Form\SLFactory\CreateFormSLFactory::class,
            \Module\LibraryBooks\Form\DeleteForm::class => \Module\LibraryBooks\Form\SLFactory\DeleteFormSLFactory::class,
            \Module\LibraryBooks\Service\CrudService::class => \Module\LibraryBooks\Service\SLFactory\CrudServiceSLFactory::class,
            \Module\LibraryBooks\Service\FilterResultsService::class => \Module\LibraryBooks\Service\SLFactory\FilterResultsServiceSLFactory::class,
        ],
    ]
];