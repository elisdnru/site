<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

$dirs = scandir(__DIR__.'/../src/modules');

$modules = [];
foreach ($dirs as $name) {
    if ($name[0] != '.') {
        $modules[$name] = ['class'=>'application.modules.' . $name . '.' . ucfirst($name) . 'Module'];
    }
}

$MODULES_MATCHES = implode('|', array_keys($modules));

return [

    'basePath'=>dirname(__DIR__).'/src',
    'runtimePath'=>dirname(__DIR__) . '/var',
    'name'=>'Site',
    'sourceLanguage'=>'en',
    'language'=>'ru',

    'import'=>[
        'application.components.*',
        'application.modules.main.components.actions.*',
        'application.modules.main.components.arbehaviors.*',
        'application.modules.main.components.behaviors.*',
        'application.modules.main.components.helpers.*',
        'application.modules.main.components.system.*',
        'application.modules.main.components.widgets.*',
        'application.modules.main.components.*',
        'application.modules.user.components.*',
        'application.modules.user.models.*',
        'application.modules.module.components.DUrlRulesHelper',
        'application.extensions.cachetagging.Tags',
    ],

    'modules'=>array_replace($modules, [
        /*'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'admin',
            'ipFilters'=>array('127.0.0.1','::1'),
        ),*/
    ]),

    'components'=>[

        'urlManager'=>[
            'class'=>'DUrlManager',
            'urlFormat'=>'path',
            'showScriptName'=>false,
            'useStrictParsing'=>true,
            'urlSuffix'=>'',
            'rules'=>[
                /*'gii'=>'gii/default/index',
                'gii/<controller:\w+>'=>'gii/<controller>/index',
                'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',*/
                '<module:' . $MODULES_MATCHES . '>/<controller:\w+[Aa]dmin>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/<action>',
                '<module:' . $MODULES_MATCHES . '>/<controller:\w+[Aa]dmin>'=>'<module>/<controller>/index',
                '<module:' . $MODULES_MATCHES . '>/<controller:\w+[Aa]dmin>/<action:\w+>'=>'<module>/<controller>/<action>',
            ],
        ],

        'user'=>[
            'class'=>'application.modules.user.components.WebUser',
            'allowAutoLogin'=>true,
            'loginUrl'=>['/user/default/login'],
        ],

        'clientScript'=>[
            'scriptMap'=>[
                'modernizr.js'=>'/js/modernizr.min.js',
                'core-site.js'=>'/js/core-site.js',
                'core-end.js'=>'/js/core-end.js',
                //'jquery.js'=>'http://code.jquery.com/jquery-latest.min.js',
                //'jquery.min.js'=>'http://code.jquery.com/jquery-latest.min.js',
                'jquery.easing.js'=>'/js/jquery.easing.js',
                'jquery.mousewheel.js'=>'/js/jquery.mousewheel.js',
                'jquery.plugins.js'=>'/js/jquery.plugins.js',
                'swfobject.js'=>'/js/swfobject.js',
            ]
        ],

        'config'=>[
            'class'=>'application.modules.config.components.DConfig',
            'cache'=>3600,
        ],

        'db'=>[
            'connectionString' => getenv('APP_DB_DSN'),
            'enableProfiling' => false,
            'emulatePrepare' => true,
            'username' => getenv('APP_DB_USERNAME'),
            'password' => getenv('APP_DB_PASSWORD'),
            'tablePrefix' => getenv('APP_DB_PREFIX'),
            'charset' => 'utf8',
            'schemaCachingDuration'=>3600,
        ],

        'authManager'=>[
            'class'=>'application.modules.user.components.PhpAuthManager',
            'defaultRoles'=>['role_guest'],
        ],

        'moduleManager'=>[
            'class'=>'application.modules.module.components.DModuleManager',
        ],

        'errorHandler'=>[
            'errorAction'=>'/main/error/index',
        ],

        'image'=>[
            'class'=>'ext.image.CImageHandler',
        ],

        'file'=>[
            'class'=>'ext.file.CFile',
        ],

        'uploader'=>[
            'class'=>'application.modules.uploader.components.DUploadManager',
            'origFileSalt'=>'adFxt0de',
            'rootPath'=>'upload',
            'emptyImage'=>'images/nophoto.png',
            'allowedThumbnailResolutions'=>[
                // general
                ['upload/images', [
                    '250x0',
                ]],
                ['upload/images/users/avatars', [
                    '100x100',
                    '50x50',
                ]],
                ['upload/images/news', [
                    '200x180', // list
                    '198x180', // greed
                ]],

                ['upload/images/news', [
                    '250x0', // default
                    '200x180', // list
                    '198x180', // greed
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

        'email'=>[
            'class'=>'ext.email.Email',
            'delivery'=>'php', //'php'|'debug'
        ],

        'mailer'=>[
            'class'=>'ext.mailer.MyEMailer',
            'pathViews'=>'//email',
            'pathLayouts'=>'//email/layouts'
        ],

        'rpcManager'=>[
            'class'=>'DRPCManager',
        ],

        'widgetFactory'=>[
            'enableSkin'=>true,
        ],

        'syntaxHighlighter' => [
            'class'=>'ext.JMSyntaxHighlighter.JMSyntaxHighlighter',
            'theme'=>'Eclipse',
        ],

        'log'=>[
            'class'=>'CLogRouter',
            'routes'=>[
                [
                    'class'=>'CFileLogRoute',
                    'levels'=>'error',
                    'logFile'=>'log_error.log',
                ],
                [
                    'class'=>'CFileLogRoute',
                    'levels'=>'warning',
                    'logFile'=>'log_warning.log',
                ],
                [
                    'class'=>'CFileLogRoute',
                    'levels'=>'info',
                    'logFile'=>'log_info.log',
                ],
            ],
        ],

        'cache'=>[
            'class'=>'system.caching.CFileCache',
            'behaviors'=>[
                'tagging'=>[
                    'class'=>'ext.cachetagging.TaggingBehavior',
                ],
            ],
        ],
    ],

    'preload'=>[
        'log',
    ],

    'behaviors'=> [
        [
            'class'=>'application.modules.module.components.DModuleUrlRulesBehavior',
            'beforeCurrentModule'=>[
                'main',
                'uploader',
                'sitemap',
                'admin',
                'user',
                'ulogin',
            ],
            'afterCurrentModule'=>[
                'page',
                'new',
            ]
        ]
    ],

    'params'=>[
        'runtimeWidgets'=>[
            'new.widgets.News',
            'new.widgets.LastNews',
            'blog.widgets.LastPosts',
            'newsgallery.widgets.NewsGallery',
            'gallery.widgets.Gallery',
            'page.widgets.SubPages',
            'page.widgets.Page',
            'menu.widgets.Menu',
            'block.widgets.Block',
            'contact.widgets.Contact',
            'portfolio.widgets.Portfolio',
        ],
        'minimize_styles' => [],
        'minimize_scripts' => [],
    ],
];
