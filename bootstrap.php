<?php

declare(strict_types=1);

use yii\BaseYii;

require_once __DIR__ . '/Yii.php';
require_once __DIR__ . '/vendor/yiisoft/yii/framework/YiiBase.php';

spl_autoload_register([BaseYii::class, 'autoload']);

Yii::$classMap = include(__DIR__ . '/vendor/yiisoft/yii2/classes.php');
Yii::$container = new yii\di\Container();
