<?php

return [
    'controllers' => [
        'invokables' => [
            'ApplicationFeatureApiV1LibraryBooks\Controller\Books' => ApplicationFeatureApiV1LibraryBooks\Controller\BooksController::class,
        ],
        'factories' => [
            'ApplicationFeatureApiV1LibraryBooks\Controller\GetList' => ApplicationFeatureApiV1LibraryBooks\Controller\SLFactory\GetListControllerSLFactory::class,
            'ApplicationFeatureApiV1LibraryBooks\Controller\Get' => ApplicationFeatureApiV1LibraryBooks\Controller\SLFactory\GetControllerSLFactory::class,
            'ApplicationFeatureApiV1LibraryBooks\Controller\Create' => ApplicationFeatureApiV1LibraryBooks\Controller\SLFactory\CreateControllerSLFactory::class,
            'ApplicationFeatureApiV1LibraryBooks\Controller\Delete' => ApplicationFeatureApiV1LibraryBooks\Controller\SLFactory\DeleteControllerSLFactory::class,
            'ApplicationFeatureApiV1LibraryBooks\Controller\Update' => ApplicationFeatureApiV1LibraryBooks\Controller\SLFactory\UpdateControllerSLFactory::class,
        ],
    ]
];