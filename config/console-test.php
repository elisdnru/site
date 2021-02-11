<?php

use yii\db\Connection;
use yii\helpers\ArrayHelper;

return ArrayHelper::merge(
    require(__DIR__ . '/console.php'),
    [
        'container' => [
            'singletons' => [
                Connection::class => [
                    'dsn' => 'mysql:host=mysql-test;dbname=test',
                    'username' => 'test',
                    'password' => 'secret',
                ],
            ],
        ],
    ]
);
