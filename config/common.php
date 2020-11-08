<?php

use app\components\module\admin\AdminDashboard;
use app\components\module\admin\AdminMenu;
use app\components\module\admin\AdminAccess;
use app\modules\edu\widgets\SeriesEpisodes;
use app\components\ContentReplaceBehavior;
use app\components\MathCaptchaAction;
use app\components\InlineWidgetsBehavior;
use app\components\module\admin\AdminNotifications;
use app\components\module\routes\RoutesLoader;
use app\components\uploader\Uploader;
use app\components\AuthManager;
use app\widgets\inline\CountDown;
use app\widgets\inline\MailTo;
use app\widgets\inline\SubscribeNews;
use app\widgets\inline\SubscribeWebinars;
use app\extensions\image\ImageHandler;
use app\modules\block\widgets\BlockWidget;
use app\modules\blog\widgets\LastPostsWidget;
use yii\caching\CacheInterface;
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

return [
    'id' => 'app',
    'basePath' => dirname(__DIR__) . '/src',
    'vendorPath' => dirname(__DIR__) . '/vendor',
    'runtimePath' => $runtime,
    'name' => 'Site',
    'sourceLanguage' => 'en',
    'language' => 'ru',

    'bootstrap' => [
        RoutesLoader::class,
        app\components\psr\Provider::class,
        app\components\module\sitemap\Provider::class,
        app\modules\edu\components\Provider::class,
    ],

    'modules' => [
        'admin' => ['class' => app\modules\admin\Module::class],
        'block' => ['class' => app\modules\block\Module::class],
        'blog' => ['class' => app\modules\blog\Module::class],
        'comment' => ['class' => app\modules\comment\Module::class],
        'contacts' => ['class' => app\modules\contacts\Module::class],
        'donate' => ['class' => app\modules\donate\Module::class],
        'file' => ['class' => app\modules\file\Module::class],
        'home' => ['class' => app\modules\home\Module::class],
        'edu' => ['class' => app\modules\edu\Module::class],
        'page' => ['class' => app\modules\page\Module::class],
        'landing' => ['class' => app\modules\landing\Module::class],
        'portfolio' => ['class' => app\modules\portfolio\Module::class],
        'products' => ['class' => app\modules\products\Module::class],
        'search' => ['class' => app\modules\search\Module::class],
        'services' => ['class' => app\modules\services\Module::class],
        'sitemap' => ['class' => app\modules\sitemap\Module::class],
        'subscribe' => ['class' => app\modules\subscribe\Module::class],
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
            'dsn' => 'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'),
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
                'host' => getenv('MAILER_HOST'),
                'port' => getenv('MAILER_PORT'),
                'username' => getenv('MAILER_USER'),
                'password' => getenv('MAILER_PASSWORD'),
                'encryption' => getenv('MAILER_ENCRYPTION'),
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

        'authManager' => [
            'class' => AuthManager::class,
            'itemFile' => __DIR__ . '/rbac/items.php',
            'ruleFile' => __DIR__ . '/rbac/rules.php',
            'assignmentFile' => __DIR__ . '/rbac/assignments.php',
        ],

        'moduleAdminAccess' => [
            'class' => AdminAccess::class,
        ],

        'moduleAdminDashboard' => [
            'class' => AdminDashboard::class,
        ],

        'moduleAdminMenu' => [
            'class' => AdminMenu::class,
        ],

        'moduleAdminNotifications' => [
            'class' => AdminNotifications::class,
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
                    'countdown' => CountDown::class,
                    'subscribe_webinars' => SubscribeWebinars::class,
                    'subscribe_news' => SubscribeNews::class,
                    'mailto' => MailTo::class,
                    'deworker-series-episodes' => SeriesEpisodes::class,
                ],
            ],
            'as Replace' => [
                'class' => ContentReplaceBehavior::class,
                'replaces' => [
                    'http://www.elisdn.ru' => 'https://elisdn.ru',
                ],
            ],
        ],

        'cache' => CacheInterface::class,
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
        'singletons' => [
            CacheInterface::class => !getenv('APP_DEBUG') ? [
                'class' => FileCache::class,
                'dirMode' => 0777,
                'fileMode' => 0666,
            ] : [
                'class' => DummyCache::class,
            ]
        ],
    ],

    'params' => [
        'GENERAL.ADMIN_EMAIL' => getenv('MAILER_FROM_EMAIL'),
    ],
];
