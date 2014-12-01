<?php

use Zend\Mvc\Router\Http;

return [
    'router' => [
        'routes' => [
            'library' => [
                'child_routes'  => [
                    'books'    => [
                        'type'          => Http\Literal::class,
                        'options'       => [
                            'route'    => '/books',
                            'defaults' => [
                                '__NAMESPACE__' => 'Module\LibraryBooks\Controller',
                                'controller'    => 'index',
                                'action'        => 'index',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes'  => [
                            '*'      => [
                                'type'          => Http\Wildcard::class,
                                'options'       => [
                                    'key_value_delimiter' => '/',
                                    'param_delimiter'     => '/',
                                ],
                                'may_terminate' => true,
                            ],
                            'create' => [
                                'type'          => Http\Literal::class,
                                'options'       => [
                                    'route'    => '/create',
                                    'defaults' => [
                                        'controller' => 'create',
                                    ],
                                ],
                                'may_terminate' => true,
                            ],
                            'read'   => [
                                'type'          => Http\Segment::class,
                                'options'       => [
                                    'route'       => '/read[/:id]',
                                    'constraints' => [
                                        'id' => '[0-9]+',
                                    ],
                                    'defaults'    => [
                                        'controller' => 'read',
                                    ],
                                ],
                                'may_terminate' => true,
                            ],
                            'update' => [
                                'type'          => Http\Segment::class,
                                'options'       => [
                                    'route'       => '/update[/:id]',
                                    'constraints' => [
                                        'id' => '[0-9]+',
                                    ],
                                    'defaults'    => [
                                        'controller' => 'update',
                                    ],
                                ],
                                'may_terminate' => true,
                            ],
                            'delete' => [
                                'type'          => Http\Segment::class,
                                'options'       => [
                                    'route'       => '/delete[/:id]',
                                    'constraints' => [
                                        'id' => '[0-9]+',
                                    ],
                                    'defaults'    => [
                                        'controller' => 'delete',
                                    ],
                                ],
                                'may_terminate' => true,
                            ],
                        ]
                    ],
                ],
            ],
        ],
    ],
];