<?php

return [
    'view_manager' => array(
        'template_map' => array(
            'library/index/index' => __DIR__ . '/../view/library/index/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
];