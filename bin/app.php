#!/usr/bin/env php
<?php

use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
    (new Dotenv())->usePutenv()->load(__DIR__ . '/../.env');
}

require_once __DIR__ . '/../config/env.php';
require_once __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

if (getenv('APP_ENV') === 'test') {
    $config = require __DIR__ . '/../config/console-test.php';
} else {
    $config = require __DIR__ . '/../config/console.php';
}

$app = new yii\console\Application($config);
$app->run();
