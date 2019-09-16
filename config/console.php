<?php

return array_replace_recursive(
    require(__DIR__ . '/common.php'),
    [
        'commandMap' => [
            'cache' => [
                'class' => \app\commands\CacheCommand::class,
            ],
            'minimize' => [
                'class' => \app\commands\minimize\MinimizeCommand::class,
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
            'minimize_styles' => [
                '../public/build/main.css' => [
                    '../public/css/_system.css',
                    '../public/css/_layout.css',
                    '../public/css/_style.css',
                    '../public/css/_typo.css',
                    '../public/css/_portlet.css',
                    '../public/css/_pager.css',
                    '../public/css/_follow.css',
                    '../public/css/_calendar.css',
                    '../public/css/_home.css',
                    '../public/css/_media.css',
                ],
            ],
            'minimize_scripts' => [
                '../public/build/main.js' => [
                    '../public/js/jquery.plugins.js',
                    '../public/js/follow.js',
                    '../public/js/justclick.js',
                    '../public/js/core-site.js',
                ],
            ],
        ]
    ]
);
