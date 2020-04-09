<?php

use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
    (new Dotenv(true))->load(__DIR__ . '/../.env');
}

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

ob_start();
$app->run();
$html = ob_get_clean();

echo str_replace('http://www.elisdn.ru', 'https://elisdn.ru', $html);

