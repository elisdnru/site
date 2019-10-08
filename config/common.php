<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

use app\extensions\file\CFile;
use app\extensions\image\CImageHandler;
use app\modules\block\widgets\BlockWidget;
use app\modules\blog\widgets\LastPostsWidget;
use app\modules\contact\widgets\ContactWidget;
use app\modules\page\widgets\PageWidget;
use app\modules\portfolio\widgets\PortfolioWidget;

CHtml::setModelNameConverter(static function ($model) {
    return is_object($model) ? (new ReflectionObject($model))->getShortName() : (string)$model;
});

$modules = [
    'admin' => ['class' => app\modules\admin\Module::class],
    'block' => ['class' => app\modules\block\Module::class],
    'blog' => ['class' => app\modules\blog\Module::class],
    'comment' => ['class' => app\modules\comment\Module::class],
    'contact' => ['class' => app\modules\contact\Module::class],
    'file' => ['class' => app\modules\file\Module::class],
    'main' => ['class' => app\modules\main\Module::class],
    'menu' => ['class' => app\modules\menu\Module::class],
    'page' => ['class' => app\modules\page\Module::class],
    'portfolio' => ['class' => app\modules\portfolio\Module::class],
    'search' => ['class' => app\modules\search\Module::class],
    'sitemap' => ['class' => app\modules\sitemap\Module::class],
    'ulogin' => ['class' => app\modules\ulogin\Module::class],
    'image' => ['class' => app\modules\image\Module::class],
    'user' => ['class' => app\modules\user\Module::class],
];

$MODULES_MATCHES = implode('|', array_keys($modules));

$runtime = dirname(__DIR__) . '/var/' . PHP_SAPI;

if (!is_dir($runtime)) {
    CFileHelper::createDirectory($runtime);
}

$assetsVersion = @filemtime(dirname(__DIR__) . '/public/build');

return [

    'basePath' => dirname(__DIR__) . '/src',
    'runtimePath' => $runtime,
    'name' => 'Site',
    'sourceLanguage' => 'en',
    'language' => 'ru',

    'modules' => $modules,

    'components' => [

        'urlManager' => [
            'class' => \app\components\system\UrlManager::class,
            'urlFormat' => 'path',
            'showScriptName' => false,
            'useStrictParsing' => true,
            'urlSuffix' => '',
            'rules' => [
                '<module:' . $MODULES_MATCHES . '>/<controller:\w+[Aa]dmin>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
                '<module:' . $MODULES_MATCHES . '>/<controller:\w+[Aa]dmin>' => '<module>/<controller>/index',
                '<module:' . $MODULES_MATCHES . '>/<controller:\w+[Aa]dmin>/<action:\w+>' => '<module>/<controller>/<action>',
            ],
        ],

        'user' => [
            'class' => \app\modules\user\components\WebUser::class,
            'allowAutoLogin' => true,
            'loginUrl' => ['/user/default/login'],
        ],

        'clientScript' => [
            'coreScriptPosition' => CClientScript::POS_END,
            'defaultScriptFilePosition' => CClientScript::POS_END,
            'packages' => [
                'jquery' => [
                    'basePath' => null,
                    'baseUrl' => '/build',
                    'js' => ['jquery.js?v=' . $assetsVersion],
                ],
                'main' => [
                    'basePath' => null,
                    'baseUrl' => '/build',
                    'css' => ['main.css?v=' . $assetsVersion],
                    'js' => ['site.js?v=' . $assetsVersion],
                ],
                'admin' => [
                    'basePath' => null,
                    'baseUrl' => '/build',
                    'css' => ['admin.css?v=' . $assetsVersion],
                    'depends' => ['main'],
                ],
                'admin-bar' => [
                    'basePath' => null,
                    'baseUrl' => '/build',
                    'css' => ['admin-bar.css?v=' . $assetsVersion],
                    'depends' => ['main'],
                ],
                'comments' => [
                    'basePath' => null,
                    'baseUrl' => '/build',
                    'css' => ['comments.css?v=' . $assetsVersion],
                    'js' => ['comments.js?v=' . $assetsVersion],
                    'depends' => ['main'],
                ],
                'portfolio' => [
                    'basePath' => null,
                    'baseUrl' => '/build',
                    'css' => ['portfolio.css?v=' . $assetsVersion],
                    'depends' => ['main'],
                ],
                'blog-post' => [
                    'basePath' => null,
                    'baseUrl' => '/build',
                    'css' => ['blog-post.css?v=' . $assetsVersion],
                    'depends' => ['main'],
                ],
                'smart' => [
                    'basePath' => null,
                    'baseUrl' => '/build',
                    'css' => ['smart.css?v=' . $assetsVersion],
                    'depends' => ['main'],
                ],
                'jcarousellite' => [
                    'basePath' => null,
                    'baseUrl' => '/build',
                    'js' => ['jcarousellite.js?v=' . $assetsVersion],
                    'depends' => ['jquery'],
                ],
            ],
        ],

        'db' => [
            'connectionString' => getenv('APP_DB_DSN'),
            'enableProfiling' => false,
            'emulatePrepare' => true,
            'username' => getenv('APP_DB_USERNAME'),
            'password' => getenv('APP_DB_PASSWORD'),
            'charset' => 'utf8',
            'schemaCachingDuration' => 3600,
        ],

        'authManager' => [
            'class' => \app\components\PhpAuthManager::class,
            'defaultRoles' => ['role_guest'],
        ],

        'moduleManager' => [
            'class' => \app\components\module\ModuleManager::class,
        ],

        'errorHandler' => [
            'errorAction' => '/main/error/index',
        ],

        'image' => [
            'class' => CImageHandler::class,
        ],

        'file' => [
            'class' => CFile::class,
        ],

        'uploader' => [
            'class' => \app\components\uploader\UploadManager::class,
            'origFileSalt' => 'adFxt0de',
            'rootPath' => 'upload',
            'emptyImage' => 'images/nophoto.png',
            'allowedThumbnailResolutions' => [
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

        'email' => [
            'class' => \app\extensions\email\Email::class,
            'delivery' => 'php', //'php'|'debug'
        ],

        'rpcManager' => [
            'class' => \app\components\RPCManager::class,
        ],

        'widgetFactory' => [
            'enableSkin' => true,
        ],

        'log' => [
            'class' => \CLogRouter::class,
            'routes' => [
                [
                    'class' => \CFileLogRoute::class,
                    'levels' => 'error',
                    'logFile' => 'log_error.log',
                ],
                [
                    'class' => \CFileLogRoute::class,
                    'levels' => 'warning',
                    'logFile' => 'log_warning.log',
                ],
                [
                    'class' => \CFileLogRoute::class,
                    'levels' => 'info',
                    'logFile' => 'log_info.log',
                ],
            ],
        ],

        'cache' => [
            'class' => !getenv('APP_DEBUG') ? 'system.caching.CFileCache' : 'system.caching.CDummyCache',
            'behaviors' => [
                'tagging' => [
                    'class' => \app\extensions\cachetagging\TaggingBehavior::class,
                ],
            ],
        ],
    ],

    'preload' => [
        'log',
    ],

    'behaviors' => [
        [
            'class' => \app\components\module\ModuleUrlRulesBehavior::class,
            'modules' => [
                'main',
                'user',
                'blog',
                'comment',
                'contact',
                'portfolio',
                'sitemap',
                'ulogin',
                'search',
                'admin',
                'menu',
                'file',
                'block',
                'image',
                'page',
            ]
        ]
    ],

    'params' => [
        'runtimeWidgets' => [
            'lastPosts' => LastPostsWidget::class,
            'page' => PageWidget::class,
            'block' => BlockWidget::class,
            'contact' => ContactWidget::class,
            'portfolio' => PortfolioWidget::class,
        ],

        'GENERAL.SITE_NAME' => 'ElisDN',
        'GENERAL.FEED_TITLE' => 'Дмитрий Елисеев',
        'GENERAL.ADMIN_EMAIL' => 'mail@elisdn.ru',
        'GENERAL.PING_ENABLE' => true,
        'GENERAL.PING_SERVERS' => [
            'http://ping.blogs.yandex.ru/RPC2',
            'http://blogsearch.google.com/ping/RPC2',
        ],
    ],
];
