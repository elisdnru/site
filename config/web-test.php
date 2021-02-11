<?php

use yii\db\Connection;
use yii\helpers\ArrayHelper;
use yii\web\Request;

return ArrayHelper::merge(
    require(__DIR__ . '/web.php'),
    [
        'container' => [
            'singletons' => [
                Connection::class => [
                    'dsn' => 'mysql:host=mysql-test;dbname=test',
                    'username' => 'test',
                    'password' => 'secret',
                ],
                Request::class => [
                    'cookieValidationKey' => 'test',
                ],
            ],
        ],
    ]
);
