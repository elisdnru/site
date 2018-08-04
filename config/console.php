<?php

return array_replace_recursive(
    require(__DIR__ . '/common.php'),
    require(__DIR__ . '/common-local.php'),
    array(
        'commandMap' => array(
            'migrate' => array(
                'class' => 'application.extensions.migrate.EMigrateCommand',
                'migrationPath' => 'application.migrations',
                'migrationTable' => '{{migration}}',
                'applicationModuleName' => 'core',
                'disabledModules' => array(
                    'admin',
                ),
                'migrationSubPath' => 'migrations',
                'connectionID'=>'db',
            ),
        ),

        'params' => array(
            'minimize_styles' => array(
                '../public/css/main.css' => array(
                    '../public/css/_layout.css',
                    '../public/css/_style.css',
                    '../public/css/_typo.css',
                    '../public/css/_portlet.css',
                    '../public/css/_pager.css',
                    '../public/css/_media.css',
                ),
            ),
            'minimize_scripts' => array(
                '../public/js/main.js' => array(
                    '../public/js/jquery.plugins.js',
                    '../public/js/share.js',
                    '../public/js/follow.js',
                    '../public/js/justclick.js',
                    '../public/js/core-site.js',
                ),
            ),
        )
    ),
    require(__DIR__ . '/console-local.php')
);