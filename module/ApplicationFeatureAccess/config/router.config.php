<?php

use Zend\Mvc\Router\Http;
use ApplicationLibrary\Router\Http\SkippableSegment;

return [
    'router' => [
        'routes' => [
            'access' => [
                'type' => SkippableSegment::class,
                'options' => [
                    'route' => '[/:lang]/access',
                    'defaults' => [
                        '__NAMESPACE__' => 'ApplicationFeatureAccess\Controller',
                        'controller' => 'login',
                        'action' => 'index',
                        'lang' => '',
                    ],
                    'constraints' => array(
                        'lang' => '[a-z]{2}(-[a-zA-Z]{2}){0,1}'
                    ),
                    'skippable' => [
                        'lang' => true
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'default' => [
                        'type' => Http\Segment::class,
                        'options' => [
                            'route' => '/[:controller[/:action]]',
                            'constraints' => [
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            '*' => [
                                'type' => Http\Wildcard::class,
                                'options' => [
                                    'key_value_delimiter' => '/',
                                    'param_delimiter' => '/',
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