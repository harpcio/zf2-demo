<?php

return [
    'modules' => [
        'DoctrineModule',
        'DoctrineORMModule',
        'DluTwBootstrap',
        'BusinessLogic\\Users',
        'Module\\Auth',
        'Module\\Api',
        'Acl',
        'Application',
        'BusinessLogic\\Books',
        'Library',
        'Module\\ApiV1Library',
        'Module\\ApiV1LibraryBooks',
        'Module\\Library',
        'Module\\LibraryBooks',
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