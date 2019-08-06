<?php

use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__.'/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
    (new Dotenv())->load(__DIR__ . '/../.env');
}

require_once __DIR__.'/../config/env.php';

$yii=__DIR__.'/../vendor/yiisoft/yii/framework/yii.php';
$config=__DIR__.'/../config/web.php';

require_once($yii);

ob_start();
Yii::createWebApplication($config)->run();
$html = ob_get_clean();

echo str_replace('http://www.elisdn.ru', 'https://elisdn.ru', $html);

