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
        'cache' => array(
            'adapter' => array(
                'name' => 'Filesystem',
                'options' => array(
                    'cache_dir' => ROOT_PATH . '/data/cache',
                    'ttl' => DEVELOPMENT_ENV ? 0 : 3600
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
    'language' => [
        'should_redirect_to_recognized_language' => true,
        'default' => [
            APPLICATION_LANGUAGE => APPLICATION_LOCALE
        ],
        'available' => [
            'de' => 'de_DE',
            APPLICATION_LANGUAGE => APPLICATION_LOCALE,
            'pl' => 'pl_PL',
            'pt-br' => 'pt_BR'
        ],
    ],
);
