<?php

return [
    'doctrine' => [
        'driver' => [
            'business_logic_books_entities' => [
                'class' => Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/BusinessLogicDomainBooks/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    'BusinessLogicDomainBooks\Entity' => 'business_logic_books_entities'
                ]
            ]
        ]
    ]
];