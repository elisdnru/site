<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

$modules = [
    'admin' => ['class' => app\modules\admin\AdminModule::class],
    'block' => ['class' => app\modules\block\BlockModule::class],
    'blog' => ['class' => app\modules\blog\BlogModule::class],
    'category' => ['class' => app\modules\category\CategoryModule::class],
    'colorbox' => ['class' => app\modules\colorbox\ColorboxModule::class],
    'comment' => ['class' => app\modules\comment\CommentModule::class],
    'contact' => ['class' => app\modules\contact\ContactModule::class],
    'crud' => ['class' => app\modules\crud\CrudModule::class],
    'file' => ['class' => app\modules\file\FileModule::class],
    'follow' => ['class' => app\modules\follow\FollowModule::class],
    'main' => ['class' => app\modules\main\MainModule::class],
    'menu' => ['class' => app\modules\menu\MenuModule::class],
    'page' => ['class' => app\modules\page\PageModule::class],
    'portfolio' => ['class' => app\modules\portfolio\PortfolioModule::class],
    'share' => ['class' => app\modules\share\ShareModule::class],
    'search' => ['class' => app\modules\search\SearchModule::class],
    'sitemap' => ['class' => app\modules\sitemap\SitemapModule::class],
    'tinymce' => ['class' => app\modules\tinymce\TinymceModule::class],
    'ulogin' => ['class' => app\modules\ulogin\UloginModule::class],
    'uploader' => ['class' => app\modules\uploader\UploaderModule::class],
    'user' => ['class' => app\modules\user\UserModule::class],
];

$MODULES_MATCHES = implode('|', array_keys($modules));

return [

    'basePath' => dirname(__DIR__) . '/src',
    'runtimePath' => dirname(__DIR__) . '/var',
    'name' => 'Site',
    'sourceLanguage' => 'en',
    'language' => 'ru',

    'import' => [
        'application.components.*',
        'application.components.module.*',
        'application.extensions.cachetagging.*',
        'application.extensions.email.*',
        'application.extensions.feed.*',
        'application.extensions.file.*',
        'application.extensions.image.*',
        'application.extensions.JMSyntaxHighlighter.*',
        'application.extensions.migrate.*',
        'application.modules.block.models.*',
        'application.modules.block.widgets.*',
        'application.modules.blog.extensions.multicomplete.*',
        'application.modules.blog.models.*',
        'application.modules.blog.widgets.*',
        'application.modules.category.components.*',
        'application.modules.category.models.*',
        'application.modules.colorbox.widgets.*',
        'application.modules.comment.components.*',
        'application.modules.comment.models.*',
        'application.modules.comment.widgets.*',
        'application.modules.contact.models.*',
        'application.modules.contact.widgets.*',
        'application.modules.crud.components.*',
        'application.modules.file.models.*',
        'application.modules.file.extensions.uploadify.*',
        'application.modules.follow.widgets.*',
        'application.modules.main.components.actions.*',
        'application.modules.main.components.arbehaviors.*',
        'application.modules.main.components.behaviors.*',
        'application.modules.main.components.helpers.*',
        'application.modules.main.components.system.*',
        'application.modules.main.components.widgets.*',
        'application.modules.main.components.*',
        'application.modules.main.widgets.*',
        'application.modules.menu.models.*',
        'application.modules.menu.widgets.*',
        'application.modules.page.components.*',
        'application.modules.page.models.*',
        'application.modules.page.widgets.*',
        'application.modules.portfolio.components.*',
        'application.modules.portfolio.models.*',
        'application.modules.portfolio.widgets.*',
        'application.modules.search.components.*',
        'application.modules.search.models.*',
        'application.modules.search.widgets.*',
        'application.modules.share.widgets.*',
        'application.modules.sitemap.components.*',
        'application.modules.tinymce.widgets.*',
        'application.modules.ulogin.components.*',
        'application.modules.ulogin.models.*',
        'application.modules.ulogin.widgets.*',
        'application.modules.uploader.components.*',
        'application.modules.user.components.*',
        'application.modules.user.models.*',
        'application.modules.user.widgets.*',
    ],

    'modules' => $modules,

    'components' => [

        'urlManager' => [
            'class' => \DUrlManager::class,
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
            'class' => \WebUser::class,
            'allowAutoLogin' => true,
            'loginUrl' => ['/user/default/login'],
        ],

        'clientScript' => [
            'packages' => [
                'jquery' => [
                    'basePath' => 'application.assets.jquery',
                    'js' => [YII_DEBUG ? 'jquery.js' : 'jquery.min.js'],
                ],
            ],
            'scriptMap' => [
                'modernizr.js' => '/js/modernizr.min.js',
                'core-site.js' => '/js/core-site.js',
                'core-end.js' => '/js/core-end.js',
                'jquery.easing.js' => '/js/jquery.easing.js',
                'jquery.plugins.js' => '/js/jquery.plugins.js',
                'swfobject.js' => '/js/swfobject.js',
            ]
        ],

        'db' => [
            'connectionString' => getenv('APP_DB_DSN'),
            'enableProfiling' => false,
            'emulatePrepare' => true,
            'username' => getenv('APP_DB_USERNAME'),
            'password' => getenv('APP_DB_PASSWORD'),
            'tablePrefix' => getenv('APP_DB_PREFIX'),
            'charset' => 'utf8',
            'schemaCachingDuration' => 3600,
        ],

        'authManager' => [
            'class' => \PhpAuthManager::class,
            'defaultRoles' => ['role_guest'],
        ],

        'moduleManager' => [
            'class' => \DModuleManager::class,
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
            'class' => \DUploadManager::class,
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
            'class' => \Email::class,
            'delivery' => 'php', //'php'|'debug'
        ],

        'rpcManager' => [
            'class' => \DRPCManager::class,
        ],

        'widgetFactory' => [
            'enableSkin' => true,
        ],

        'syntaxHighlighter' => [
            'class' => \JMSyntaxHighlighter::class,
            'theme' => 'Eclipse',
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
                    'class' => \TaggingBehavior::class,
                ],
            ],
        ],
    ],

    'preload' => [
        'log',
    ],

    'behaviors' => [
        [
            'class' => \DModuleUrlRulesBehavior::class,
            'beforeCurrentModule' => [
                'main',
                'uploader',
                'sitemap',
                'admin',
                'user',
                'ulogin',
            ],
            'afterCurrentModule' => [
                'page',
                'new',
            ]
        ]
    ],

    'params' => [
        'runtimeWidgets' => [
            'lastPosts' => LastPostsWidget::class,
            'subPages' => SubPagesWidget::class,
            'page' => PageWidget::class,
            'menu' => MenuWidget::class,
            'block' => BlockWidget::class,
            'contact' => ContactWidget::class,
            'portfolio' => PortfolioWidget::class,
        ],
        'minimize_styles' => [],
        'minimize_scripts' => [],

        'GENERAL.SITE_NAME' => 'ElisDN',
        'GENERAL.FEED_TITLE' => 'Дмитрий Елисеев',
        'GENERAL.ADMIN_EMAIL' => 'mail@elisdn.ru',
        'GENERAL.SOCIAL_VK_APIID' => '2126755',
        'GENERAL.PING_ENABLE' => true,
        'GENERAL.PING_SERVERS' => [
            'http://ping.blogs.yandex.ru/RPC2',
            'http://blogsearch.google.com/ping/RPC2',
        ],
    ],
];
