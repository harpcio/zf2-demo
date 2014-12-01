<?php

return [
    'doctrine' => [
        'driver' => [
            'business_logic_users_entities' => [
                'class' => Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Users/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    'BusinessLogic\Users\Entity' => 'business_logic_users_entities'
                ]
            ]
        ]
    ]
];