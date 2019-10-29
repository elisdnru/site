#!/usr/bin/env php
<?php

use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
    (new Dotenv())->load(__DIR__ . '/../.env');
}

require_once __DIR__ . '/../config/env.php';

require_once __DIR__ . '/../bootstrap.php';

Yii::createConsoleApplication(__DIR__ . '/../config/console.php');

$yii2Config = require __DIR__ . '/../config/v2/console.php';
$app = new yii\console\Application($yii2Config);
$app->run();
