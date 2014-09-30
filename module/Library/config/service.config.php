<?php

return [
    'service_manager' => [
        'invokables' => [
            Library\Form\Book\CreateFormInputFilter::class => Library\Form\Book\CreateFormInputFilter::class,
            Library\Form\DeleteFormInputFilter::class => Library\Form\DeleteFormInputFilter::class,
        ],
        'abstract_factories' => [
        ],
        'aliases' => [
        ],
        'factories' => [
            Library\Repository\BookRepository::class => Library\Repository\Factory\BookRepositoryFactory::class,
            Library\Form\Book\CreateForm::class => Library\Form\Book\Factory\CreateFormFactory::class,
            Library\Form\DeleteForm::class => Library\Form\Factory\DeleteFormFactory::class,
            Library\Service\Book\CrudService::class => Library\Service\Book\Factory\CrudServiceFactory::class,
        ],
    ]
];