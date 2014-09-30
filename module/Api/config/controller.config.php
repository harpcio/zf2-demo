<?php

return [
    'controllers' => [
        'invokables' => [
            'Api\Controller\NotFound' => Api\Controller\NotFoundController::class,
            'Api\Controller\V1\Library\Book' => Api\Controller\V1\Library\BookController::class,
        ],
        'factories' => [
            'Api\Controller\V1\Library\Book\GetList' => Api\Controller\V1\Library\Book\Factory\GetListControllerFactory::class,
            'Api\Controller\V1\Library\Book\Get' => Api\Controller\V1\Library\Book\Factory\GetControllerFactory::class,
            'Api\Controller\V1\Library\Book\Create' => Api\Controller\V1\Library\Book\Factory\CreateControllerFactory::class,
            'Api\Controller\V1\Library\Book\Delete' => Api\Controller\V1\Library\Book\Factory\DeleteControllerFactory::class,
            'Api\Controller\V1\Library\Book\Update' => Api\Controller\V1\Library\Book\Factory\UpdateControllerFactory::class,
        ],
    ]
];