<?php

return array_replace_recursive(
    require(__DIR__ . '/common.php'),
    [
        'components' => [
            'request' => [
                'class' => \DHttpRequest::class,
                'baseUrl' => '',
                'noCsrfValidationUris' => [
                    '^file/fileAdmin/(upload|checkexists).*$',
                    '^ulogin.*$',
                ],
                'enableCsrfValidation' => true,
                'enableCookieValidation' => true,
            ],
            'session' => [
                'class' => 'system.web.CHttpSession',
                'timeout' => 3600 * 24 * 10,
                'cookieParams' => [
                    'lifetime' => 3600 * 24 * 10,
                ],
            ],
        ],
    ]
);
