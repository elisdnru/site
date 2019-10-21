<?php

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(
    require(__DIR__ . '/common.php'),
    [
        'controllerMap' => [],

        'components' => [
            'db' => [
                'dsn' => 'mysql:host=mysql-test;dbname=test',
                'username' => 'test',
                'password' => 'secret',
            ],
        ],
    ]
);
