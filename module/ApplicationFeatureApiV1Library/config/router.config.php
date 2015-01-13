<?php

use Zend\Mvc\Router\Http;

return [
    'router' => [
        'routes' => [
            'api' => [
                'child_routes' => [
                    'library' => [
                        'type' => Http\Segment::class,
                        'options' => [
                            'route' => '/library',
                            'defaults' => [
                                '__NAMESPACE__' => 'ApplicationFeatureApi\Controller',
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
                        ]
                    ],
                ]
            ],
        ],
    ],
];