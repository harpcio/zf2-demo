<?php

return [
    'controllers' => [
        'invokables' => [
            'Module\ApiV1LibraryBooks\Controller\Books' => Module\ApiV1LibraryBooks\Controller\BooksController::class,
        ],
        'factories' => [
            'Module\ApiV1LibraryBooks\Controller\GetList' => Module\ApiV1LibraryBooks\Controller\SLFactory\GetListControllerSLFactory::class,
            'Module\ApiV1LibraryBooks\Controller\Get' => Module\ApiV1LibraryBooks\Controller\SLFactory\GetControllerSLFactory::class,
            'Module\ApiV1LibraryBooks\Controller\Create' => Module\ApiV1LibraryBooks\Controller\SLFactory\CreateControllerSLFactory::class,
            'Module\ApiV1LibraryBooks\Controller\Delete' => Module\ApiV1LibraryBooks\Controller\SLFactory\DeleteControllerSLFactory::class,
            'Module\ApiV1LibraryBooks\Controller\Update' => Module\ApiV1LibraryBooks\Controller\SLFactory\UpdateControllerSLFactory::class,
        ],
    ]
];