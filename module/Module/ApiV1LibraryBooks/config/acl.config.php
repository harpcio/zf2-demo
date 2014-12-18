<?php

use BusinessLogic\Users\Entity\UserEntityInterface;

return [
    'acl' => [
        UserEntityInterface::ROLE_GUEST => [
            'parents' => [],
            'allow' => [
                'Module\ApiV1LibraryBooks' => [
                    'GetList:index',
                    'Get:index'
                ],
            ],
            'deny' => []
        ],
        UserEntityInterface::ROLE_ADMIN => [
            'parents' => [],
            'allow' => [
                'Module\ApiV1LibraryBooks' => [],
            ],
            'deny' => []
        ]
    ]
];