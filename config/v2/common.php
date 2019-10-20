<?php

$runtime = dirname(__DIR__, 2) . '/var/' . PHP_SAPI;

if (!is_dir($runtime)) {
    CFileHelper::createDirectory($runtime);
}

$mailerUri = parse_url(getenv('MAILER_URI'));
parse_str($mailerUri['query'], $mailerQuery);

return [
    'id' => 'app',
    'basePath' => dirname(__DIR__, 2) . '/src',
    'runtimePath' => $runtime,
    'name' => 'Site',
    'sourceLanguage' => 'en',
    'language' => 'ru',

    'modules' => [],

    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'suffix' => '',
            'rules' => [
                '<module:\w+>/admin/<controller:\w+>' => '<module>/admin/<controller>/index',
                '<module:\w+>/admin/<controller:\w+>/<id:\d+>/<action:\w+>' => '<module>/admin/<controller>/<action>',
                '<module:\w+>/admin/<controller:\w+>/<action:\w+>' => '<module>/admin/<controller>/<action>',
            ],
        ],

        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => getenv('APP_DB_DSN'),
            'username' => getenv('APP_DB_USERNAME'),
            'password' => getenv('APP_DB_PASSWORD'),
            'tablePrefix' => '',
            'charset' => 'utf8',
            'enableSchemaCache' => true,
        ],

        'mailer' => [
            'class' => yii\swiftmailer\Mailer::class,
            'viewPath' => '@app/views/email',
            'transport' => [
                'class' => Swift_SmtpTransport::class,
                'host' => $mailerUri['host'],
                'port' => $mailerUri['port'],
                'username' => $mailerUri['user'],
                'password' => $mailerUri['pass'],
                'encryption' => $mailerQuery['encryption'],
            ],
            'messageConfig' => [
                'from' => getenv('MAILER_FROM_EMAIL'),
            ],
        ],

        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                \yii\web\JqueryAsset::class => [
                    'sourcePath' => null,
                    'baseUrl' => '/build',
                    'js' => ['jquery.js'],
                ],
            ],
        ],

        'image' => [
            'class' => \app\extensions\image\ImageHandler::class,
        ],

        'file' => [
            'class' => \app\extensions\file\File::class,
        ],

        'uploader' => [
            'class' => \app\components\uploader\Uploader::class,
            'rootPath' => 'upload',
            'emptyImage' => 'images/nophoto.png',
            'allowedThumbnailResolutions' => [
                ['upload/media', [
                    '680x0',
                ]],
                // general
                ['upload/images', [
                    '250x0',
                ]],
                ['upload/images/users/avatars', [
                    '100x100',
                    '50x50',
                ]],
                ['upload/images/portfolio', [
                    '198x0', // greed
                    '190x0', // homepage
                    '50x0', // admin
                ]],
                ['upload/images/blogs', [
                    '100x100', // last posts
                ]],
                ['upload/images/users/avatars', [
                    '100x100',
                    '50x50',
                ]],
                ['upload/images/users/galleries', [
                    '250x0', // admin
                ]],
                ['upload/images/pages', [
                    '250x0', // default
                ]],
            ],
        ],

        'log' => [
            'class' => yii\log\Dispatcher::class,
            'traceLevel' => YII_DEBUG ? 3 : 0,
        ],

        'cache' => [
            'class' => !getenv('APP_DEBUG') ? \yii\caching\FileCache::class : \yii\caching\DummyCache::class,
        ],
    ],

    'params' => [],
];
