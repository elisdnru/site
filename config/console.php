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
                'migrationTable' => 'migrations',
                'applicationModuleName' => 'core',
                'disabledModules' => [
                    'admin',
                ],
                'migrationSubPath' => 'migrations',
                'connectionID' => 'db',
            ],
        ],

        'params' => []
    ]
);
