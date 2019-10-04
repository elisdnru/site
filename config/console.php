<?php

return array_replace_recursive(
    require(__DIR__ . '/common.php'),
    [
        'commandMap' => [
            'cache' => [
                'class' => \app\commands\CacheCommand::class,
            ],
            'migrate' => [
                'class' => \app\extensions\migrate\EMigrateCommand::class,
                'migrationPath' => 'application.migrations',
                'migrationTable' => '{{migration}}',
                'applicationModuleName' => 'core',
                'disabledModules' => [
                    'admin',
                ],
                'migrationSubPath' => 'migrations',
                'connectionID' => 'db',
            ],
        ],

        'params' => [
            'minimize_scripts' => [
                '../public/js/main.js' => [
                    '../public/js/jquery.plugins.js',
                    '../public/js/follow.js',
                    '../public/js/core-site.js',
                ],
            ],
        ]
    ]
);
