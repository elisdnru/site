<?php

declare(strict_types=1);

use yii\web\Application;

require_once __DIR__ . '/../vendor/autoload.php';

if ($dsn = env('SENTRY_DSN')) {
    Sentry\init(['dsn' => $dsn]);
}

require_once __DIR__ . '/../config/env.php';
require_once __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

/**
 * @var array<string, mixed>
 */
$config = require __DIR__ . '/../config/web.php';

$app = new Application($config);
$app->run();
