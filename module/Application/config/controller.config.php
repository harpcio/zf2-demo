<?php

use Zend\Mvc\Controller\ControllerManager;

return [
    'controllers' => [
        'invokables' => [
            'Application\Controller\Index' => Application\Controller\IndexController::class
        ],
        'factories' => [
        ],
    ]
];