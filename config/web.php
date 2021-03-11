<?php

use app\components\SentryErrorHandler;
use app\components\AuthIdentity;
use yii\helpers\ArrayHelper;
use yii\web\Cookie;
use yii\web\ErrorHandler;
use yii\web\Request;
use yii\web\Session;
use yii\web\User;

/**
 * @psalm-var array{
 *     HTTP_X_FORWARDED_PROTO?: string,
 *     HTTPS?: string
 * } $_SERVER
 */

$isSecure =
    (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') ||
    (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off');

return ArrayHelper::merge(
    require(__DIR__ . '/common.php'),
    [
        'components' => [
            'request' => Request::class,
            'user' => User::class,
            'session' => Session::class,
            'errorHandler' => [
                'class' => ErrorHandler::class
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
                    'cookieValidationKey' => getenv('COOKIE_SECRET'),
                    'csrfCookie' => [
                        'httpOnly' => true,
                        'secure' => $isSecure,
                    ]
                ],
                Session::class => [
                    'class' => Session::class,
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
                    'sentryActive' => !(bool)getenv('APP_DEBUG'),
                ],
            ],
        ],
    ]
);
