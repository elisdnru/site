<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

if (getenv('SENTRY_DSN')) {
    Sentry\init(['dsn' => getenv('SENTRY_DSN')]);
}

require_once __DIR__ . '/../config/env.php';
require_once __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

if (getenv('APP_ENV') === 'test') {
    $config = require __DIR__ . '/../config/web-test.php';
} else {
    $config = require __DIR__ . '/../config/web.php';
}

$app = new yii\web\Application($config);
$app->run();
