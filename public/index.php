<?php

use app\components\behaviors\SentryBehavior;
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

$yii2Config = require __DIR__ . '/../config/v2/web.php';
new yii\web\Application($yii2Config);

$app = Yii::createWebApplication(__DIR__ . '/../config/web.php');
$app->attachBehavior('SentryBehavior', new SentryBehavior(!(bool)getenv('APP_DEBUG')));

ob_start();
$app->run();
$html = ob_get_clean();

echo str_replace('http://www.elisdn.ru', 'https://elisdn.ru', $html);

