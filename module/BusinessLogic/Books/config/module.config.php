<?php

return [
    'doctrine' => [
        'driver' => [
            'business_logic_books_entities' => [
                'class' => Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'filesystem',
                'paths' => [__DIR__ . '/../src/Books/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    'BusinessLogic\Books\Entity' => 'business_logic_books_entities'
                ]
            ]
        ]
    ]
];