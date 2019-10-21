<?php

return array_replace_recursive(
    require(__DIR__ . '/common.php'),
    require(__DIR__ . '/web.php'),
    [
        'components' => [
            'fixture' => [
                'class' => 'system.test.CDbFixtureManager',
                'basePath' => dirname(__DIR__) . '/tests/fixtures'
            ],

            'request' => [
                'hostInfo' => 'http://localhost',
            ],

            'log' => [
                'class' => CLogRouter::class,
                'routes' => [
                    [
                        'class' => CFileLogRoute::class,
                        'levels' => 'error',
                    ],
                ],
            ],

            'db' => [
                'connectionString' => 'mysql:host=mysql-test;dbname=test',
                'username' => 'test',
                'password' => 'secret',
            ],

            'cache' => [
                'class' => 'system.caching.CDummyCache',
            ],
        ],

        'params' => [],
    ]
);
