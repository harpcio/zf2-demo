<?php

use BusinessLogicDomainUsers\Entity\UserEntityInterface;

return [
    'acl' => [
        UserEntityInterface::ROLE_GUEST => [
            'parents' => [],
            'allow' => [
                'ApplicationFeatureAccess' => [],
            ],
            'deny' => []
        ],
        UserEntityInterface::ROLE_ADMIN => [
            'parents' => [],
            'allow' => [],
            'deny' => []
        ]
    ]
];