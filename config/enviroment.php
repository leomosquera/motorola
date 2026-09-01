<?php
return [
    'assurant' => [
        'type' => env('ASSURANT_TYPE', 'production'),
        'url'  => env('ASSURANT_URL'),
        'auth' => [
            'user' => env('ASSURANT_AUTH_USER'),
            'pass' => env('ASSURANT_AUTH_PASS'),
        ],
        'terms' => [
            'url' => env('ASSURANT_TERMS_URL'),
        ],
    ],
    'sendmail' => [
        'type' => env('SENDMAIL_TYPE', 'local'),

        'local' => [
            'from' => env('SENDMAIL_LOCAL_FROM'),
            'bcc'  => env('SENDMAIL_LOCAL_BCC'),
        ],
        'mailersend' => [
            'proteccion-motocare' => [
                'type'       => env('MAILERSEND_MOTOCARE_TYPE', 'dev'),
                'token_dev'  => env('MAILERSEND_MOTOCARE_TOKEN_DEV'),
                'token_prod' => env('MAILERSEND_MOTOCARE_TOKEN_PROD'),
                'from'       => env('MAILERSEND_MOTOCARE_FROM'),
                'bcc'        => env('MAILERSEND_MOTOCARE_BCC'),
            ],
        ],
    ],
];