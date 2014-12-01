<?php

return [
    'controllers' => [
        'invokables' => [
        ],
        'factories' => [
            'Module\LibraryBooks\Controller\Index' => Module\LibraryBooks\Controller\SLFactory\IndexControllerSLFactory::class,
            'Module\LibraryBooks\Controller\Create' => Module\LibraryBooks\Controller\SLFactory\CreateControllerSLFactory::class,
            'Module\LibraryBooks\Controller\Update' => Module\LibraryBooks\Controller\SLFactory\UpdateControllerSLFactory::class,
            'Module\LibraryBooks\Controller\Delete' => Module\LibraryBooks\Controller\SLFactory\DeleteControllerSLFactory::class,
            'Module\LibraryBooks\Controller\Read' => Module\LibraryBooks\Controller\SLFactory\ReadControllerSLFactory::class,
        ],
    ]
];