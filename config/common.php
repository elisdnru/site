<?php

use app\components\AuthManager;
use app\components\ContentReplaceBehavior;
use app\components\InlineWidgetsBehavior;
use app\components\MathCaptchaAction;
use app\components\module\admin\AdminAccess;
use app\components\module\admin\AdminDashboard;
use app\components\module\admin\AdminMenu;
use app\components\module\admin\AdminNotifications;
use app\components\module\routes\RoutesLoader;
use app\components\uploader\Uploader;
use app\extensions\file\File as FileExtension;
use app\extensions\image\Image;
use app\modules\block\widgets\BlockWidget;
use app\modules\blog\widgets\LastPostsWidget;
use app\modules\edu\widgets\SeriesEpisodes;
use app\widgets\inline\CountDown;
use app\widgets\inline\MailTo;
use app\widgets\inline\SubscribeNews;
use app\widgets\inline\SubscribeWebinars;
use yii\caching\CacheInterface;
use yii\caching\DummyCache;
use yii\caching\FileCache;
use yii\data\Pagination;
use yii\db\Connection;
use yii\helpers\FileHelper;
use yii\log\Dispatcher;
use yii\mail\MailerInterface;
use yii\rbac\ManagerInterface;
use yii\swiftmailer\Mailer;
use yii\web\AssetManager;
use yii\web\JqueryAsset;
use yii\web\UrlManager;
use yii\web\View;
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
        app\components\psr\HttpFactoryProvider::class,
        app\components\psr\HttpClientProvider::class,
        app\components\psr\SimpleCacheProvider::class,
        \app\components\module\Provider::class,
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
        'partner' => ['class' => app\modules\partner\Module::class],
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
        'urlManager' => UrlManager::class,
        'db' => Connection::class,
        'mailer' => MailerInterface::class,
        'assetManager' => AssetManager::class,
        'authManager' => ManagerInterface::class,
        'log' => Dispatcher::class,
        'view' => View::class,
        'cache' => CacheInterface::class,
        'moduleAdminAccess' => AdminAccess::class,
        'moduleAdminDashboard' => AdminDashboard::class,
        'moduleAdminMenu' => AdminMenu::class,
        'moduleAdminNotifications' => AdminNotifications::class,
        'file' => FileExtension::class,
        'uploader' => Uploader::class,
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
            UrlManager::class => [
                'class' => UrlManager::class,
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
            Connection::class => [
                'class' => Connection::class,
                'dsn' => 'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'),
                'username' => getenv('DB_USERNAME'),
                'password' => getenv('DB_PASSWORD'),
                'tablePrefix' => '',
                'charset' => 'utf8mb4',
                'enableSchemaCache' => true,
            ],
            AssetManager::class => [
                'class' => AssetManager::class,
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
            ManagerInterface::class => [
                'class' => AuthManager::class,
                'itemFile' => __DIR__ . '/rbac/items.php',
                'ruleFile' => __DIR__ . '/rbac/rules.php',
                'assignmentFile' => __DIR__ . '/rbac/assignments.php',
            ],
            Dispatcher::class => [
                'class' => Dispatcher::class,
                'traceLevel' => YII_DEBUG ? 3 : 0,
            ],
            CacheInterface::class => !getenv('APP_DEBUG') ? [
                'class' => FileCache::class,
                'dirMode' => 0777,
                'fileMode' => 0666,
            ] : [
                'class' => DummyCache::class,
            ],
            MailerInterface::class => [
                'class' => Mailer::class,
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
            View::class => [
                'class' => View::class,
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
            Image::class => [],
            FileExtension::class => [],
            Uploader::class => [
                'class' => Uploader::class,
                'rootPath' => 'upload',
                'emptyImage' => 'images/nophoto.png',
                'allowedThumbnailResolutions' => [
                    ['upload/media', [
                        '680x0',
                    ]],
                    ['upload/images', [
                        '250x0',
                    ]],
                    ['upload/images/users/avatars', [
                        '100x100',
                        '50x50',
                    ]],
                    ['upload/images/portfolio', [
                        '198x0', // index
                        '190x0', // widget
                        '50x0', // admin
                    ]],
                    ['upload/images/blogs', [
                        '100x100', // last posts
                    ]],
                ],
            ],
            AdminAccess::class => [],
            AdminDashboard::class => [],
            AdminMenu::class => [],
            AdminNotifications::class => [],
        ],
    ],
    'params' => [
        'deworker_api_url' => getenv('DEWORKER_API_URL')
    ],
];
