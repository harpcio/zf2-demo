<?php

use BusinessLogicDomainUsers\Entity\UserEntityInterface;

return [
    'acl' => [
        UserEntityInterface::ROLE_GUEST => [
            'parents' => [],
            'allow' => [
                'ApplicationFeatureApiV1LibraryBooks' => [
                    'GetList:index',
                    'Get:index'
                ],
            ],
            'deny' => []
        ],
        UserEntityInterface::ROLE_ADMIN => [
            'parents' => [],
            'allow' => [
                'ApplicationFeatureApiV1LibraryBooks' => [],
            ],
            'deny' => []
        ]
    ]
];