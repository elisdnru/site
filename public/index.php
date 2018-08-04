<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../config/env.php';

require_once(__DIR__.'/../src/components/DTimer.php');
DTimer::run();

$yii=__DIR__.'/../vendor/yiisoft/yii/framework/yii.php';
$config=__DIR__.'/../config/web.php';

require_once($yii);
Yii::createWebApplication($config)->run();
