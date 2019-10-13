<?php

return array_replace_recursive(
    require(__DIR__ . '/common.php'),
    [
        'components' => [
            'request' => [
                'class' => \app\components\system\HttpRequest::class,
                'baseUrl' => '',
                'noCsrfValidationUris' => [
                    '^file/admin/file/(upload|checkexists).*$',
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
            'assetManager' => [
                'linkAssets' => true,
            ],
        ],
    ]
);
