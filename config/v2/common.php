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
        'log' => [
            'class' => yii\log\Dispatcher::class,
            'traceLevel' => YII_DEBUG ? 3 : 0,
        ],
    ],

    'params' => [],
];
