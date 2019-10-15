#!/usr/bin/env php
<?php

use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
    (new Dotenv())->load(__DIR__ . '/../.env');
}

require_once __DIR__ . '/../config/env.php';

require_once __DIR__ . '/../bootstrap.php';

$yii2Config = require __DIR__ . '/../config/v2/console.php';
new yii\console\Application($yii2Config);

$config = __DIR__ . '/../config/console.php';

$app=Yii::createConsoleApplication($config);
$app->commandRunner->addCommands(YII_PATH.'/cli/commands');
$app->run();
