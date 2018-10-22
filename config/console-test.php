<?php

return array_replace_recursive(
    require(__DIR__ . '/common.php'),
    [
        'commandMap' => [
            'migrate' => [
                'class' => 'application.extensions.migrate.EMigrateCommand',
                'migrationPath' => 'application.migrations',
                'migrationTable' => '{{migration}}',
                'applicationModuleName' => 'core',
                'disabledModules' => [
                    'admin',
                ],
                'migrationSubPath' => 'migrations',
                'connectionID'=>'db',
            ],
        ],

        'components' => [
            'db'=>[
                'connectionString' => 'mysql:host=mysql-test;dbname=test',
                'username' => 'test',
                'password' => 'secret',
                'tablePrefix' => '',
            ],
        ],
    ]
);
