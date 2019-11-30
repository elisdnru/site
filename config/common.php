<?php

use app\components\MathCaptchaAction;
use app\components\InlineWidgetsBehavior;
use app\components\module\ModuleManager;
use app\components\module\routes\ModuleUrlRules;
use app\components\SentryErrorHandler;
use app\components\uploader\Uploader;
use app\components\AuthManager;
use app\widgets\inline\CountDownWidget;
use app\widgets\inline\MailToWidget;
use app\widgets\inline\SubscribeNewsWidget;
use app\widgets\inline\SubscribeWebinarsWidget;
use app\extensions\image\ImageHandler;
use app\modules\block\widgets\BlockWidget;
use app\modules\blog\widgets\LastPostsWidget;
use app\modules\contact\widgets\ContactWidget;
use app\modules\portfolio\widgets\PortfolioWidget;
use yii\caching\DummyCache;
use yii\caching\FileCache;
use yii\data\Pagination;
use yii\db\Connection;
use yii\helpers\FileHelper;
use yii\web\JqueryAsset;
use yii\widgets\LinkPager;

$runtime = dirname(__DIR__) . '/var/' . PHP_SAPI;

if (!is_dir($runtime)) {
    FileHelper::createDirectory($runtime, 0777);
}

$mailerUri = parse_url(getenv('MAILER_URI'));
parse_str($mailerUri['query'], $mailerQuery);

return [
    'id' => 'app',
    'basePath' => dirname(__DIR__) . '/src',
    'vendorPath' => dirname(__DIR__) . '/vendor',
    'runtimePath' => $runtime,
    'name' => 'Site',
    'sourceLanguage' => 'en',
    'language' => 'ru',

    'bootstrap' => [
        ModuleUrlRules::class,
    ],

    'modules' => [
        'admin' => ['class' => app\modules\admin\Module::class],
        'block' => ['class' => app\modules\block\Module::class],
        'blog' => ['class' => app\modules\blog\Module::class],
        'comment' => ['class' => app\modules\comment\Module::class],
        'contact' => ['class' => app\modules\contact\Module::class],
        'file' => ['class' => app\modules\file\Module::class],
        'home' => ['class' => app\modules\home\Module::class],
        'menu' => ['class' => app\modules\menu\Module::class],
        'page' => ['class' => app\modules\page\Module::class],
        'landing' => ['class' => app\modules\landing\Module::class],
        'portfolio' => ['class' => app\modules\portfolio\Module::class],
        'search' => ['class' => app\modules\search\Module::class],
        'sitemap' => ['class' => app\modules\sitemap\Module::class],
        'ulogin' => ['class' => app\modules\ulogin\Module::class],
        'image' => ['class' => app\modules\image\Module::class],
        'user' => ['class' => app\modules\user\Module::class],
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
            'linkAssets' => true,
            'appendTimestamp' => true,
            'bundles' => [
                JqueryAsset::class => [
                    'sourcePath' => null,
                    'baseUrl' => '/build',
                    'js' => ['jquery.js'],
                ],
            ],
        ],

        'errorHandler' => [
            'class' => SentryErrorHandler::class,
            'errorAction' => 'home/error/index',
            'sentryActive' => !(bool)getenv('APP_DEBUG'),
        ],

        'authManager' => [
            'class' => AuthManager::class,
            'itemFile' => __DIR__ . '/rbac/items.php',
            'ruleFile' => __DIR__ . '/rbac/rules.php',
            'assignmentFile' => __DIR__ . '/rbac/assignments.php',
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

        'view' => [
            'as InlineWidgetsBehavior' => [
                'class' => InlineWidgetsBehavior::class,
                'widgets' => [
                    'lastPosts' => LastPostsWidget::class,
                    'block' => BlockWidget::class,
                    'contact' => ContactWidget::class,
                    'portfolio' => PortfolioWidget::class,
                    'countdown' => CountDownWidget::class,
                    'subscribe_webinars' => SubscribeWebinarsWidget::class,
                    'subscribe_news' => SubscribeNewsWidget::class,
                    'mailto' => MailToWidget::class,
                ],
            ],
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
            Pagination::class => [
                'validatePage' => false,
            ],
            MathCaptchaAction::class => [
                'backColor' => 0xffffff,
                'foreColor' => 0xa00090,
            ],
        ],
    ],

    'params' => [
        'GENERAL.ADMIN_EMAIL' => getenv('MAILER_FROM_EMAIL'),
    ],
];
