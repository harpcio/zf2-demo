<?php
return [
    'navigation' => [
        'default' => [
            'Application' => [
                'label' => 'Home',
                'route' => 'home',
                'resource' => 'application',
                'controller' => 'index',
                'action' => 'index',
                'privilege' => 'index:index',
                'order' => 1,
            ],
        ],
    ]
];
