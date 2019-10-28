<?php

use app\components\UserIdentity;
use yii\helpers\ArrayHelper;
use yii\web\Cookie;

$useSecureCookie = isset($_SERVER['HTTPS']) && (strcasecmp($_SERVER['HTTPS'], 'on') === 0 || $_SERVER['HTTPS'] === '1');

return ArrayHelper::merge(
    require(__DIR__ . '/common.php'),
    [
        'components' => [
            'request' => [
                'cookieValidationKey' => getenv('COOKIE_SECRET'),
                'csrfCookie' => [
                    'httpOnly' => true,
                    'secure' => $useSecureCookie,
                ]
            ],

            'user' => [
                'identityClass' => UserIdentity::class,
                'enableAutoLogin' => true,
                'identityCookie' => [
                    'name' => '_identity',
                    'httpOnly' => true,
                    'secure' => $useSecureCookie,
                ],
                'loginUrl' => ['/user/default/login'],
            ],

            'session' => [
                'cookieParams' => [
                    'httpOnly' => true,
                    'secure' => $useSecureCookie,
                ],
            ],
        ],

        'container' => [
            'definitions' => [
                Cookie::class => [
                    'httpOnly' => true,
                    'secure' => $useSecureCookie,
                ],
            ],
        ],
    ]
);
