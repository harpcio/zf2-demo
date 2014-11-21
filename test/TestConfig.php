<?php

return [
    'modules' => [
        'DoctrineModule',
        'DoctrineORMModule',
        'DluTwBootstrap',
        'Auth',
        'Application',
        'User',
        'Library',
        'Api',
    ],
    'module_listener_options' => [
        'config_glob_paths' => [
            ROOT_PATH . '/config/autoload/{,*.}{global,local,test}.php',
        ],
        'module_paths'      => [
            'module',
            'vendor',
            'test',
        ],
    ],
];