<?php

return [
    'service_manager' => [
        'invokables' => [
        ],
        'factories' => [
            \BusinessLogicLibrary\QueryFilter\QueryFilter::class => \ApplicationLibrary\QueryFilter\SLFactory\QueryFilterSLFactory::class,
        ],
    ]
];