<?php

return array(
    'translator' => array(
        'locale' => APPLICATION_LOCALE,
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
        'cache' => DEVELOPMENT_ENV ? null : array(
            'adapter' => array(
                'name' => 'Filesystem',
                'options' => array(
                    'cache_dir' => ROOT_PATH . '/data/cache',
                    'ttl' => 3600
                )
            ),
            'plugins' => array(
                array(
                    'name' => 'serializer',
                    'options' => array()
                ),
                'exception_handler' => array(
                    'throw_exceptions' => true
                )
            )
        ),
    ),
);
