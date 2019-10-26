<?php

use app\components\module\ModuleManager;
use app\components\module\routes\v2\ModuleUrlRules;
use app\components\uploader\Uploader;
use app\extensions\image\ImageHandler;
use yii\caching\DummyCache;
use yii\caching\FileCache;
use yii\db\Connection;
use yii\web\JqueryAsset;
use yii\widgets\LinkPager;

$runtime = dirname(__DIR__, 2) . '/var/' . PHP_SAPI;

if (!is_dir($runtime)) {
    CFileHelper::createDirectory($runtime);
}

$mailerUri = parse_url(getenv('MAILER_URI'));
parse_str($mailerUri['query'], $mailerQuery);

return [
    'id' => 'app',
    'basePath' => dirname(__DIR__, 2) . '/src',
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'runtimePath' => $runtime,
    'name' => 'Site',
    'sourceLanguage' => 'en',
    'language' => 'ru',

    'bootstrap' => [
        ModuleUrlRules::class,
    ],

    'modules' => [
        'admin' => ['class' => app\modules\admin\V2Module::class],
        'block' => ['class' => app\modules\block\V2Module::class],
        'blog' => ['class' => app\modules\blog\V2Module::class],
        'comment' => ['class' => app\modules\comment\V2Module::class],
        'contact' => ['class' => app\modules\contact\V2Module::class],
        'file' => ['class' => app\modules\file\V2Module::class],
        'main' => ['class' => app\modules\main\V2Module::class],
        'menu' => ['class' => app\modules\menu\V2Module::class],
        'page' => ['class' => app\modules\page\V2Module::class],
        'landing' => ['class' => app\modules\landing\V2Module::class],
        'portfolio' => ['class' => app\modules\portfolio\V2Module::class],
        'search' => ['class' => app\modules\search\V2Module::class],
        'sitemap' => ['class' => app\modules\sitemap\V2Module::class],
        'ulogin' => ['class' => app\modules\ulogin\V2Module::class],
        'image' => ['class' => app\modules\image\V2Module::class],
        'user' => ['class' => app\modules\user\V2Module::class],
    ],

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
            'class' => Connection::class,
            'dsn' => getenv('DB_DSN'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
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
                'username' => $mailerUri['user'] ?? '',
                'password' => $mailerUri['pass'] ?? '',
                'encryption' => $mailerQuery['encryption'],
            ],
            'messageConfig' => [
                'from' => getenv('MAILER_FROM_EMAIL'),
            ],
        ],

        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                JqueryAsset::class => [
                    'sourcePath' => null,
                    'baseUrl' => '/build',
                    'js' => ['jquery.js'],
                ],
            ],
        ],

        'moduleManager' => [
            'class' => ModuleManager::class,
        ],

        'image' => [
            'class' => ImageHandler::class,
        ],

        'file' => [
            'class' => \app\extensions\file\File::class,
        ],

        'uploader' => [
            'class' => Uploader::class,
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

        'cache' => !getenv('APP_DEBUG') ? [
            'class' => FileCache::class,
            'dirMode' => 0777,
            'fileMode' => 0666,
        ] : [
            'class' => DummyCache::class,
        ],
    ],

    'container' => [
        'definitions' => [
            LinkPager::class => [
                'prevPageLabel' => '&laquo; назад',
                'nextPageLabel' => 'далее &raquo;',
            ],
        ],
    ],

    'params' => [],
];
