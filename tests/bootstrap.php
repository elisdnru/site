<?php

use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__.'/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
    (new Dotenv())->load(__DIR__ . '/../.env');
}

require_once __DIR__.'/../config/env.php';
$yiit=__DIR__.'/../vendor/yiisoft/yii/framework/yiit.php';
$config=__DIR__.'/../config/test.php';

require_once($yiit);
require_once(__DIR__.'/DbTestCase.php');

Yii::createWebApplication($config);
