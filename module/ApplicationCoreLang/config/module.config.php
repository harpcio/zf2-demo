<?php

return array(
    'language' => [
        'should_redirect_to_recognized_language' => false,
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
