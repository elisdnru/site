<?php

use app\extensions\migrate\EMigrateCommand;

return array_replace_recursive(
    require(__DIR__ . '/common.php'),
    [
        'commandMap' => [
            'migrate' => [
                'class' => EMigrateCommand::class,
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

        'components' => [
            'db' => [
                'connectionString' => 'mysql:host=mysql-test;dbname=test',
                'username' => 'test',
                'password' => 'secret',
            ],
        ],
    ]
);
