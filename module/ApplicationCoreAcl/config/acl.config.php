<?php

use BusinessLogicDomainUsers\Entity\UserEntityInterface;

return [
    'acl' => [
        UserEntityInterface::ROLE_GUEST => [
            'parents' => [],
            'allow' => [
                'Application' => [],
                'ApplicationCoreAuth' => [],
            ],
            'deny' => [
                'ApplicationCoreAuth' => [
                    'NoAccess:index'
                ]
            ]
        ],
        UserEntityInterface::ROLE_ADMIN => [
            'parents' => [UserEntityInterface::ROLE_GUEST],
            'allow' => [
                'ApplicationCoreAuth' => [
                    'NoAccess:index'
                ]
            ],
            'deny' => []
        ]
    ]
];