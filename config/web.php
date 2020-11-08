<?php

use app\components\SentryErrorHandler;
use app\components\AuthIdentity;
use yii\helpers\ArrayHelper;
use yii\web\Cookie;
use yii\web\User;

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

            'user' => User::class,

            'session' => [
                'cookieParams' => [
                    'httpOnly' => true,
                    'secure' => $useSecureCookie,
                ],
            ],

            'errorHandler' => [
                'class' => SentryErrorHandler::class,
                'errorAction' => 'home/error/index',
                'sentryActive' => !(bool)getenv('APP_DEBUG'),
            ],
        ],

        'container' => [
            'definitions' => [
                Cookie::class => [
                    'httpOnly' => true,
                    'secure' => $useSecureCookie,
                ],
            ],
            'singletons' => [
                User::class => [
                    'identityClass' => AuthIdentity::class,
                    'enableAutoLogin' => true,
                    'identityCookie' => [
                        'name' => '_identity',
                        'httpOnly' => true,
                        'secure' => $useSecureCookie,
                    ],
                    'loginUrl' => ['/user/default/login'],
                ],
            ],
        ],
    ]
);
