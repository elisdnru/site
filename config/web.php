<?php

declare(strict_types=1);

use app\components\AuthIdentity;
use app\components\SentryErrorHandler;
use yii\helpers\ArrayHelper;
use yii\redis\Session as RedisSession;
use yii\web\Cookie;
use yii\web\ErrorHandler;
use yii\web\Request;
use yii\web\Session;
use yii\web\User;

$isSecure = parse_url(env('APP_URL'), PHP_URL_SCHEME) === 'https';

return ArrayHelper::merge(
    require(__DIR__ . '/common.php'),
    [
        'components' => [
            'request' => Request::class,
            'user' => User::class,
            'session' => Session::class,
            'errorHandler' => [
                'class' => ErrorHandler::class,
            ],
        ],

        'container' => [
            'definitions' => [
                Cookie::class => [
                    'httpOnly' => true,
                    'secure' => $isSecure,
                ],
            ],
            'singletons' => [
                Request::class => [
                    'class' => Request::class,
                    'trustedHosts' => [
                        '10.0.0.0/8',
                    ],
                    'cookieValidationKey' => env('COOKIE_SECRET'),
                    'csrfCookie' => [
                        'httpOnly' => true,
                        'secure' => $isSecure,
                    ],
                ],
                Session::class => [
                    'class' => RedisSession::class,
                    'cookieParams' => [
                        'httpOnly' => true,
                        'secure' => $isSecure,
                    ],
                ],
                User::class => [
                    'identityClass' => AuthIdentity::class,
                    'enableAutoLogin' => true,
                    'identityCookie' => [
                        'name' => '_identity',
                        'httpOnly' => true,
                        'secure' => $isSecure,
                    ],
                    'loginUrl' => ['/user/default/login'],
                ],
                ErrorHandler::class => [
                    'class' => SentryErrorHandler::class,
                    'errorAction' => 'home/error/index',
                    'sentryActive' => !(bool)env('APP_DEBUG', ''),
                ],
            ],
        ],
    ]
);
