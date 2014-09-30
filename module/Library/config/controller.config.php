<?php

return [
    'controllers' => [
        'invokables' => [
        ],
        'factories' => [
            'Library\Controller\Book\Index' => Library\Controller\Book\Factory\IndexControllerFactory::class,
            'Library\Controller\Book\Create' => Library\Controller\Book\Factory\CreateControllerFactory::class,
            'Library\Controller\Book\Update' => Library\Controller\Book\Factory\UpdateControllerFactory::class,
            'Library\Controller\Book\Delete' => Library\Controller\Book\Factory\DeleteControllerFactory::class,
            'Library\Controller\Book\Read' => Library\Controller\Book\Factory\ReadControllerFactory::class,
        ],
    ]
];