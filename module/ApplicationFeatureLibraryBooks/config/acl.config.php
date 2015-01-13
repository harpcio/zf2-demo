<?php

use BusinessLogicDomainUsers\Entity\UserEntityInterface;

return [
    'acl' => [
        UserEntityInterface::ROLE_GUEST => [
            'parents' => [],
            'allow' => [
                'ApplicationFeatureLibraryBooks' => [
                    'Index:index',
                    'Read:index'
                ],
            ],
            'deny' => []
        ],
        UserEntityInterface::ROLE_ADMIN => [
            'parents' => [],
            'allow' => [
                'ApplicationFeatureLibraryBooks' => [],
            ],
            'deny' => []
        ]
    ]
];