<?php

return array_replace_recursive(
    require(__DIR__ . '/common.php'),
    require(__DIR__ . '/common-local.php'),
    require(__DIR__ . '/web.php'),
    require(__DIR__ . '/web-local.php'),
    [
        'components'=>[
            'fixture'=>[
                'class'=>'system.test.CDbFixtureManager',
                'basePath'=>dirname(__DIR__).'/tests/fixtures'
            ],

            'request' => [
                'hostInfo' => 'http://localhost',
            ],

            'log'=>[
                'class'=>'CLogRouter',
                'routes'=>[
                    [
                        'class'=>'CFileLogRoute',
                        'levels'=>'error',
                    ],
                ],
            ],
        ],

        'params'=>[],
    ],
    require(__DIR__ . '/test-local.php')
);
