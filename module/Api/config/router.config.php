<?php

use Zend\Mvc\Router\Http;

return [
    'router' => [
        'routes' => [
            'api' => [
                'type' => Http\Literal::class,
                'options' => [
                    'route' => '/api',
                    'defaults' => [
                        '__NAMESPACE__' => 'Api\Controller',
                        'controller' => 'notFound',
                        'action' => 'notFound'
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'wildcard' => [
                        'type' => Http\Segment::class,
                        'options' => [
                            'route' => '[/:wildcard]',
                            'constraints' => [
                                'wildcard' => '.*',
                            ],
                        ],
                        'may_terminate' => true,
                    ],
                    'library' => [
                        'type' => Http\Segment::class,
                        'options' => [
                            'route' => '/library',
                            'defaults' => [
                                '__NAMESPACE__' => 'Api\Controller',
                                'controller' => 'notFound',
                                'action' => 'notFound'
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'book' => [
                                'type' => Http\Segment::class,
                                'options' => [
                                    'route' => '/book[/:id]',
                                    'constraints' => [
                                        'id' => '[0-9]+',
                                    ],
                                    'defaults' => [
                                        '__NAMESPACE__' => 'Api\Controller\V1\Library',
                                        'controller' => 'book',
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