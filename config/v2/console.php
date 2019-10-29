<?php

use fishvision\migrate\controllers\MigrateController;
use yii\helpers\ArrayHelper;

return ArrayHelper::merge(
    require(__DIR__ . '/common.php'),
    [
        'controllerMap' => [
            'migrate' => [
                'class' => MigrateController::class,
                'migrationTable' => 'migrations',
                'autoDiscover' => true,
                'migrationPaths' => [
                    '@app/modules/block',
                    '@app/modules/blog',
                    '@app/modules/comment',
                    '@app/modules/contact',
                    '@app/modules/file',
                    '@app/modules/landing',
                    '@app/modules/menu',
                    '@app/modules/page',
                    '@app/modules/portfolio',
                    '@app/modules/user',
                ],
            ],
        ],
    ]
);
