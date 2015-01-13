<?php

return [
    'modules' => [
        'DoctrineModule',
        'DoctrineORMModule',
        'DluTwBootstrap',
        'BusinessLogicDomainUsers',
        'BusinessLogicDomainBooks',
        'Application',
        'ApplicationCoreAuth',
        'ApplicationCoreAcl',
        'ApplicationCoreLang',
        'ApplicationLibrary',
        'ApplicationFeatureAccess',
        'ApplicationFeatureApi',
        'ApplicationFeatureApiV1Library',
        'ApplicationFeatureApiV1LibraryBooks',
        'ApplicationFeatureLibrary',
        'ApplicationFeatureLibraryBooks',
    ],
    'module_listener_options' => [
        'config_glob_paths' => [
            ROOT_PATH . '/config/autoload/{,*.}{global,local,test}.php',
        ],
        'module_paths'      => [
            'module',
            'vendor',
        ],
    ],
];