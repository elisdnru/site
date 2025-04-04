<?php

declare(strict_types=1);

use app\components\AuthManager;
use app\components\ContentReplaceBehavior;
use app\components\feature\FeatureToggle;
use app\components\MathCaptchaAction;
use app\components\module\admin\AdminAccess;
use app\components\module\admin\AdminDashboard;
use app\components\module\admin\AdminMenu;
use app\components\module\admin\AdminNotifications;
use app\components\module\Provider;
use app\components\module\routes\RoutesLoader;
use app\components\module\sitemap\GroupsFetcher;
use app\components\shortcodes\ShortcodesProcessor;
use app\components\shortcodes\WidgetRenderer;
use app\components\SimpleCacheAdapter;
use app\components\uploader\Uploader;
use app\extensions\file\File as FileExtension;
use app\extensions\image\Image;
use app\modules\admin\Module;
use app\modules\block\widgets\BlockWidget;
use app\modules\blog\widgets\LastPostsWidget;
use app\modules\edu\widgets\SeriesEpisodes;
use app\modules\partner\model\ItemsFetcher;
use app\widgets\inline\CountDown;
use app\widgets\inline\MailTo;
use app\widgets\inline\RuTube;
use app\widgets\inline\SubscribeNews;
use app\widgets\inline\SubscribeWebinars;
use app\widgets\inline\YouTube;
use codemix\streamlog\Target as StreamTarget;
use Http\Client\Curl\Client;
use Laminas\Diactoros\RequestFactory;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\StreamFactory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\SimpleCache\CacheInterface as SimpleCacheInterface;
use yii\caching\CacheInterface;
use yii\caching\FileCache;
use yii\data\Pagination;
use yii\db\Connection;
use yii\di\Instance;
use yii\log\Dispatcher;
use yii\log\FileTarget;
use yii\log\Logger;
use yii\mail\MailerInterface;
use yii\rbac\ManagerInterface;
use yii\redis\Cache as RedisCache;
use yii\redis\Connection as RedisConnection;
use yii\symfonymailer\Mailer;
use yii\web\AssetManager;
use yii\web\JqueryAsset;
use yii\web\UrlManager;
use yii\web\View;
use yii\widgets\LinkPager;

return [
    'id' => 'app',
    'basePath' => dirname(__DIR__) . '/src',
    'vendorPath' => dirname(__DIR__) . '/vendor',
    'runtimePath' => dirname(__DIR__) . '/var/' . PHP_SAPI,
    'name' => 'Site',
    'sourceLanguage' => 'en',
    'language' => 'ru',

    'bootstrap' => [
        'log',
        Provider::class,
        app\modules\edu\components\Provider::class,
        RoutesLoader::class,
    ],

    'modules' => [
        'admin' => ['class' => Module::class],
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
        'schema-cache' => 'schema-cache',
        'moduleAdminAccess' => AdminAccess::class,
        'moduleAdminDashboard' => AdminDashboard::class,
        'moduleAdminMenu' => AdminMenu::class,
        'moduleAdminNotifications' => AdminNotifications::class,
        'uploader' => Uploader::class,
        'redis' => RedisConnection::class,
        'features' => FeatureToggle::class,
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
                'backColor' => 0xFFFFFF,
                'foreColor' => 0xA00090,
                'fixedVerifyCode' => env('APP_CAPTCHA_CODE', '') ?: null,
            ],
        ],
        'singletons' => [
            UrlManager::class => [
                'class' => UrlManager::class,
                'enablePrettyUrl' => true,
                'showScriptName' => false,
                'enableStrictParsing' => true,
                'baseUrl' => '',
                'suffix' => '',
                'rules' => [
                    '<module:\w+>/admin/<controller:\w+>' => '<module>/admin/<controller>/index',
                    '<module:\w+>/admin/<controller:\w+>/<id:\d+>/<action:\w+>' => '<module>/admin/<controller>/<action>',
                    '<module:\w+>/admin/<controller:\w+>/<action:\w+>' => '<module>/admin/<controller>/<action>',
                ],
            ],
            Connection::class => [
                'class' => Connection::class,
                'dsn' => 'mysql:host=' . env('DB_HOST') . ';dbname=' . env('DB_NAME'),
                'username' => env('DB_USERNAME'),
                'password' => env('DB_PASSWORD'),
                'tablePrefix' => '',
                'charset' => 'utf8mb4',
                'enableSchemaCache' => true,
                'schemaCache' => 'schema-cache',
            ],
            RedisConnection::class => [
                'class' => RedisConnection::class,
                'hostname' => env('REDIS_HOST'),
                'port' => 6379,
                'password' => env('REDIS_PASSWORD'),
                'database' => 0,
            ],
            AssetManager::class => [
                'class' => AssetManager::class,
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
                'traceLevel' => (bool)env('APP_DEBUG', '') ? 3 : 0,
                'targets' => array_filter([
                    env('APP_ENV', 'prod') !== 'prod' ? [
                        'class' => FileTarget::class,
                        'levels' => ['error', 'warning'],
                        'logVars' => [],
                    ] : false,
                    env('APP_ENV', 'prod') === 'prod' ? [
                        'class' => StreamTarget::class,
                        'url' => 'php://stderr',
                        'levels' => ['error', 'warning'],
                        'logVars' => [],
                    ] : false,
                ]),
            ],
            Logger::class => [],
            CacheInterface::class => [
                'class' => RedisCache::class,
            ],
            'schema-cache' => [
                'class' => FileCache::class,
            ],
            MailerInterface::class => [
                'class' => Mailer::class,
                'viewPath' => '@app/views/email',
                'transport' => [
                    'scheme' => 'smtp',
                    'host' => env('MAILER_HOST'),
                    'port' => (int)env('MAILER_PORT'),
                    'username' => env('MAILER_USERNAME'),
                    'password' => env('MAILER_PASSWORD'),
                ],
                'messageConfig' => [
                    'from' => env('MAILER_FROM_EMAIL'),
                ],
            ],
            View::class => [
                'class' => View::class,
                'as Replace' => [
                    'class' => ContentReplaceBehavior::class,
                    'replaces' => [
                        'http://www.elisdn.ru' => 'https://elisdn.ru',
                    ],
                ],
            ],
            ShortcodesProcessor::class => [
                ['class' => ShortcodesProcessor::class],
                [
                    [
                        'lastPosts' => LastPostsWidget::class,
                        'block' => BlockWidget::class,
                        'countdown' => CountDown::class,
                        'rutube' => RuTube::class,
                        'youtube' => YouTube::class,
                        'subscribe_webinars' => SubscribeWebinars::class,
                        'subscribe_news' => SubscribeNews::class,
                        'mailto' => MailTo::class,
                        'deworker-series-episodes' => SeriesEpisodes::class,
                    ],
                    Instance::of(WidgetRenderer::class),
                    Instance::of(CacheInterface::class),
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
            ClientInterface::class => Client::class,
            ResponseFactoryInterface::class => ResponseFactory::class,
            RequestFactoryInterface::class => RequestFactory::class,
            StreamFactoryInterface::class => StreamFactory::class,
            SimpleCacheInterface::class => SimpleCacheAdapter::class,
            ItemsFetcher::class => [],
            GroupsFetcher::class => [],
            FeatureToggle::class => [
                ['class' => FeatureToggle::class],
                [[
                    'OAUTH' => false,
                ]],
            ],
        ],
    ],
    'params' => [
        'deworker_api_url' => env('DEWORKER_API_URL'),
    ],
];
