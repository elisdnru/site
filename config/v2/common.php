<?php

CHtml::setModelNameConverter(static function ($model) {
    return is_object($model) ? (new ReflectionObject($model))->getShortName() : (string)$model;
});

$runtime = dirname(__DIR__, 2) . '/var/' . PHP_SAPI;

if (!is_dir($runtime)) {
    CFileHelper::createDirectory($runtime);
}

return [
    'id' => 'app',
    'basePath' => dirname(__DIR__, 2) . '/src',
    'runtimePath' => $runtime,
    'name' => 'Site',
    'sourceLanguage' => 'en',
    'language' => 'ru',

    'modules' => [],

    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => getenv('APP_DB_DSN'),
            'username' => getenv('APP_DB_USERNAME'),
            'password' => getenv('APP_DB_PASSWORD'),
            'tablePrefix' => '',
            'charset' => 'utf8',
            'enableSchemaCache' => true,
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
