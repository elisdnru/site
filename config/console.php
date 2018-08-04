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
                '../public/themes/classic/css/main.css' => array(
                    '../public/themes/classic/css/_layout.css',
                    '../public/themes/classic/css/_style.css',
                    '../public/themes/classic/css/_typo.css',
                    '../public/themes/classic/css/_portlet.css',
                    '../public/themes/classic/css/_pager.css',
                    '../public/themes/classic/css/_media.css',
                ),
            ),
            'minimize_scripts' => array(
                '../public/themes/classic/js/main.js' => array(
                    '../public/js/jquery.plugins.js',
                    '../public/themes/classic/js/share.js',
                    '../public/themes/classic/js/follow.js',
                    '../public/themes/classic/js/justclick.js',
                    '../public/js/core-site.js',
                ),
            ),
        )
    ),
    require(__DIR__ . '/console-local.php')
);