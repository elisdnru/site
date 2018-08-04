<?php

require_once __DIR__.'/../vendor/autoload.php';
$yiit=__DIR__.'/../vendor/yiisoft/yii/framework/yiit.php';
$config=__DIR__.'/../config/test.php';

require_once($yiit);
require_once(__DIR__.'/DbTestCase.php');

Yii::createWebApplication($config);
