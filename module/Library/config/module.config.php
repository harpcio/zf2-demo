<?php

return [
    'doctrine' => [
        'driver' => [
            'library_entities' => [
                'class' => Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Library/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    'Library\Entity' => 'library_entities'
                ]
            ]
        ]
    ]
];