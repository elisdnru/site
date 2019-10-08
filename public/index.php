<?php

use app\components\behaviors\SentryBehavior;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__.'/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
    (new Dotenv())->load(__DIR__ . '/../.env');
}

Sentry\init(['dsn' => getenv('SENTRY_DSN')]);

require_once __DIR__.'/../config/env.php';

$yii=__DIR__.'/../vendor/yiisoft/yii/framework/yii.php';
$config=__DIR__.'/../config/web.php';

require_once($yii);

ob_start();
$app = Yii::createWebApplication($config);
$app->attachBehavior('SentryBehavior', SentryBehavior::class);
$app->run();
$html = ob_get_clean();

$html = str_replace('http://www.elisdn.ru', 'https://elisdn.ru', $html);
echo str_replace('<script type="text/javascript"', '<script', $html);

