<?php

return [
    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                // metadata cache instance to use. The retrieved service name will
                // be `doctrine.cache.$thisSetting`
                'metadata_cache'    => DEVELOPMENT_ENV ? 'array' : 'filesystem',

                // DQL queries parsing cache instance to use. The retrieved service
                // name will be `doctrine.cache.$thisSetting`
                'query_cache'       => DEVELOPMENT_ENV ? 'array' : 'filesystem',

                // ResultSet cache to use.  The retrieved service name will be
                // `doctrine.cache.$thisSetting`
                'result_cache'      => DEVELOPMENT_ENV ? 'array' : 'filesystem',

                // Mapping driver instance to use. Change this only if you don't want
                // to use the default chained driver. The retrieved service name will
                // be `doctrine.driver.$thisSetting`
                'driver'            => 'orm_default',

                // Generate proxies automatically (turn off for production)
                'generate_proxies'  => DEVELOPMENT_ENV ? true : false,

                // directory where proxies will be stored. By default, this is in
                // the `data` directory of your application
                'proxy_dir'         => ROOT_PATH . '/data/cache/doctrine-proxy',

                // namespace for generated proxy classes
                'proxy_namespace'   => 'DoctrineORMModule\Proxy',

                // SQL filters.
                'filters'           => array()
            ],
        ],
        'cache' => array(
            'filesystem' => array(
                'class' => 'Doctrine\Common\Cache\FilesystemCache',
                'directory' => ROOT_PATH . '/data/cache/doctrine-module',
            ),
        ),
        'connection' => [
            'orm_default' => [
                'params'            => [
                    'serverVersion' => '5.6' //skip platform auto detection
                ]
            ]
        ]
    ],
];