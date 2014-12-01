<?php

use BusinessLogic\Users\Entity\UserEntityInterface;

return [
    'acl' => [
        UserEntityInterface::ROLE_GUEST => [
            'parents' => [],
            'allow' => [
                'Application' => [],
                'Module\Auth' => [],
            ],
            'deny' => []
        ],
        UserEntityInterface::ROLE_ADMIN => [
            'parents' => ['guest'],
            'allow' => [],
            'deny' => []
        ]
    ]
];