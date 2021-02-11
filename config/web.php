<?php

use app\components\SentryErrorHandler;
use app\components\AuthIdentity;
use yii\helpers\ArrayHelper;
use yii\web\Cookie;
use yii\web\ErrorHandler;
use yii\web\Request;
use yii\web\Session;
use yii\web\User;

$useSecureCookie = isset($_SERVER['HTTPS']) && (strcasecmp($_SERVER['HTTPS'], 'on') === 0 || $_SERVER['HTTPS'] === '1');

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
                    'secure' => $useSecureCookie,
                ],
            ],
            'singletons' => [
                Request::class => [
                    'class' => Request::class,
                    'cookieValidationKey' => getenv('COOKIE_SECRET'),
                    'csrfCookie' => [
                        'httpOnly' => true,
                        'secure' => $useSecureCookie,
                    ]
                ],
                Session::class => [
                    'class' => Session::class,
                    'cookieParams' => [
                        'httpOnly' => true,
                        'secure' => $useSecureCookie,
                    ],
                ],
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
                ErrorHandler::class => [
                    'class' => SentryErrorHandler::class,
                    'errorAction' => 'home/error/index',
                    'sentryActive' => !(bool)getenv('APP_DEBUG'),
                ],
            ],
        ],
    ]
);
