<?php

return [
    'doctrine' => [
        'driver' => [
            'user_entities' => [
                'class' => Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/User/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    'User\Entity' => 'user_entities'
                ]
            ]
        ]
    ]
];