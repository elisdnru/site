<?php

use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__.'/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
    (new Dotenv())->load(__DIR__ . '/../.env');
}

require_once __DIR__.'/../config/env.php';
$yiic=__DIR__.'/../vendor/yiisoft/yii/framework/yiic.php';
$config=__DIR__.'/../config/console-test.php';

require_once($yiic);
