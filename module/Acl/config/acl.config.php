<?php

use BusinessLogic\Users\Entity\UserEntityInterface;

return [
    'acl' => [
        UserEntityInterface::ROLE_GUEST => [
            'parents' => [],
            'allow' => [
                'Application' => [],
                'Module\\Auth' => [],
            ],
            'deny' => [
                'Module\\Auth' => [
                    'NoAccess:index'
                ]
            ]
        ],
        UserEntityInterface::ROLE_ADMIN => [
            'parents' => [UserEntityInterface::ROLE_GUEST],
            'allow' => [
                'Module\\Auth' => [
                    'NoAccess:index'
                ]
            ],
            'deny' => []
        ]
    ]
];