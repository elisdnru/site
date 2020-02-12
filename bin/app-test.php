#!/usr/bin/env php
<?php

use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
    (new Dotenv(true))->load(__DIR__ . '/../.env');
}

require_once __DIR__ . '/../config/env.php';

require_once __DIR__ . '/../bootstrap.php';

Yii::createConsoleApplication(__DIR__ . '/../config/v1/console-test.php');

$config = require __DIR__ . '/../config/console-test.php';
$app = new yii\console\Application($config);
$app->run();
