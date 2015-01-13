<?php

return [
    'controllers' => [
        'invokables' => [
        ],
        'factories' => [
            'ApplicationFeatureLibraryBooks\Controller\Index' => ApplicationFeatureLibraryBooks\Controller\SLFactory\IndexControllerSLFactory::class,
            'ApplicationFeatureLibraryBooks\Controller\Create' => ApplicationFeatureLibraryBooks\Controller\SLFactory\CreateControllerSLFactory::class,
            'ApplicationFeatureLibraryBooks\Controller\Update' => ApplicationFeatureLibraryBooks\Controller\SLFactory\UpdateControllerSLFactory::class,
            'ApplicationFeatureLibraryBooks\Controller\Delete' => ApplicationFeatureLibraryBooks\Controller\SLFactory\DeleteControllerSLFactory::class,
            'ApplicationFeatureLibraryBooks\Controller\Read' => ApplicationFeatureLibraryBooks\Controller\SLFactory\ReadControllerSLFactory::class,
        ],
    ]
];