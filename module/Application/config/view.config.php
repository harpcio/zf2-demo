<?php

return [
    'view_manager' => [
        'display_not_found_reason' => DEVELOPMENT_ENV ? true : false,
        'display_exceptions' => DEVELOPMENT_ENV ? true : false,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'view_helpers' => [
        'invokables' => [],
        'factories' => [
            'flashMessages' => Application\View\Helper\SLFactory\FlashMessagesSLFactory::class,
        ],
    ],
];