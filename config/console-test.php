<?php

return array_replace_recursive(
    require(__DIR__ . '/common.php'),
    require(__DIR__ . '/common-local.php'),
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
    ],
    require(__DIR__ . '/console-local.php')
);
