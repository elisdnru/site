<?php

use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
    (new Dotenv())->load(__DIR__ . '/../.env');
}

if (getenv('SENTRY_DSN')) {
    Sentry\init(['dsn' => getenv('SENTRY_DSN')]);
}

require_once __DIR__ . '/../config/env.php';

require_once __DIR__ . '/../bootstrap.php';

Yii::createWebApplication(__DIR__ . '/../config/web.php');

$yii2Config = require __DIR__ . '/../config/v2/web.php';
$app2 = new yii\web\Application($yii2Config);

ob_start();
$app2->run();
$html = ob_get_clean();

echo str_replace('http://www.elisdn.ru', 'https://elisdn.ru', $html);

