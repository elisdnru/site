<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

use app\extensions\cachetagging\TaggingBehavior;

CHtml::setModelNameConverter(static function ($model) {
    return is_object($model) ? (new ReflectionObject($model))->getShortName() : (string)$model;
});

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

    'import' => [
        'zii.widgets.grid.CButtonColumn',
        'zii.widgets.grid.CDataColumn',
        'zii.widgets.grid.CGridColumn',
        'system.cli.commands.MigrateCommand',
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
            'urlFormat' => 'path',
            'caseSensitive' => false,
            'showScriptName' => false,
            'useStrictParsing' => true,
            'urlSuffix' => '',
            'rules' => [
                '<module:\w+>/admin/<controller:\w+>' => '<module>/admin/<controller>/index',
                '<module:\w+>/admin/<controller:\w+>/<id:\d+>/<action:\w+>' => '<module>/admin/<controller>/<action>',
                '<module:\w+>/admin/<controller:\w+>/<action:\w+>' => '<module>/admin/<controller>/<action>',
            ],
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
            ],
        ],

        'db' => [
            'connectionString' => getenv('DB_DSN'),
            'enableProfiling' => false,
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'tablePrefix' => '',
            'charset' => 'utf8',
            'schemaCachingDuration' => 3600,
        ],

        'widgetFactory' => [
            'enableSkin' => true,
        ],

        'log' => [
            'class' => CLogRouter::class,
            'routes' => [
                [
                    'class' => CFileLogRoute::class,
                    'levels' => 'error',
                    'logFile' => 'log_error.log',
                ],
                [
                    'class' => CFileLogRoute::class,
                    'levels' => 'warning',
                    'logFile' => 'log_warning.log',
                ],
                [
                    'class' => CFileLogRoute::class,
                    'levels' => 'info',
                    'logFile' => 'log_info.log',
                ],
            ],
        ],

        'cache' => [
            'class' => !getenv('APP_DEBUG') ? 'system.caching.CFileCache' : 'system.caching.CDummyCache',
            'behaviors' => [
                'tagging' => [
                    'class' => TaggingBehavior::class,
                ],
            ],
        ],
    ],
];
