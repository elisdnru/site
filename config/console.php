<?php

use fishvision\migrate\controllers\MigrateController;
use yii\console\ErrorHandler;
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
                    '@app/modules/file',
                    '@app/modules/landing',
                    '@app/modules/page',
                    '@app/modules/portfolio',
                    '@app/modules/user',
                ],
            ],
        ],
        'components' => [
            'errorHandler' => [
                'class' => ErrorHandler::class,
            ],
        ],
    ],
);
