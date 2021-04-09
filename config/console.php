<?php

use yii\console\controllers\MigrateController;
use yii\console\ErrorHandler;
use yii\helpers\ArrayHelper;

return ArrayHelper::merge(
    require(__DIR__ . '/common.php'),
    [
        'controllerMap' => [
            'migrate' => [
                'class' => MigrateController::class,
                'migrationTable' => 'migrations',
                'migrationPath' => [
                    '@app/modules/block/migrations/global',
                    '@app/modules/blog/migrations/global',
                    '@app/modules/comment/migrations/global',
                    '@app/modules/file/migrations/global',
                    '@app/modules/landing/migrations/global',
                    '@app/modules/page/migrations/global',
                    '@app/modules/portfolio/migrations/global',
                    '@app/modules/user/migrations/global',
                ],
                'migrationNamespaces' => [
                    'app\modules\block\migrations',
                    'app\modules\blog\migrations',
                    'app\modules\comment\migrations',
                    'app\modules\file\migrations',
                    'app\modules\landing\migrations',
                    'app\modules\page\migrations',
                    'app\modules\portfolio\migrations',
                    'app\modules\user\migrations',
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
