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
                    '../public/css/_media.css',
                ],
            ],
            'minimize_scripts' => [
                '../public/build/main.js' => [
                    '../public/js/jquery.plugins.js',
                    '../public/js/share.js',
                    '../public/js/follow.js',
                    '../public/js/justclick.js',
                    '../public/js/core-site.js',
                ],
            ],
        ]
    ]
);
