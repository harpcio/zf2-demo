<?php

use Zend\Mvc\Router\Http;

return [
    'router' => [
        'routes' => [
            'api' => [
                'child_routes' => [
                    'library' => [
                        'child_routes' => [
                            'books' => [
                                'type' => Http\Segment::class,
                                'options' => [
                                    'route' => '/books[/:id]',
                                    'constraints' => [
                                        'id' => '[0-9]+',
                                    ],
                                    'defaults' => [
                                        '__NAMESPACE__' => 'ApplicationFeatureApiV1LibraryBooks\Controller',
                                        'controller' => 'books',
                                        'action' => null
                                    ],
                                ],
                                'may_terminate' => true,
                            ],
                        ]
                    ],
                ]
            ],
        ],
    ],
];