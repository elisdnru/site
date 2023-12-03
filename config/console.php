<?php

declare(strict_types=1);

use yii\console\controllers\FixtureController;
use yii\console\controllers\MigrateController;
use yii\console\ErrorHandler;
use yii\helpers\ArrayHelper;

return ArrayHelper::merge(
    require (__DIR__ . '/common.php'),
    [
        'controllerMap' => array_filter([
            'migrate' => [
                'class' => MigrateController::class,
                'migrationTable' => 'migrations',
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
            'fixture' => env('APP_ENV', 'prod') === 'dev' ? [
                'class' => FixtureController::class,
                'namespace' => 'app\fixtures',
            ] : false,
        ]),
        'components' => [
            'errorHandler' => [
                'class' => ErrorHandler::class,
            ],
        ],
    ],
);
