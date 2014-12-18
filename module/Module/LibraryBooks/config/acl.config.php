<?php

use BusinessLogic\Users\Entity\UserEntityInterface;

return [
    'acl' => [
        UserEntityInterface::ROLE_GUEST => [
            'parents' => [],
            'allow' => [
                'Module\LibraryBooks' => [
                    'Index:index',
                    'Read:index'
                ],
            ],
            'deny' => []
        ],
        UserEntityInterface::ROLE_ADMIN => [
            'parents' => [],
            'allow' => [
                'Module\LibraryBooks' => [],
            ],
            'deny' => []
        ]
    ]
];