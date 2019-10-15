<?php

declare(strict_types=1);

use yii\BaseYii;

require_once __DIR__ . '/Yii.php';

$yii2path = __DIR__ . '/vendor/yiisoft/yii2';

$yii1path = __DIR__ . '/vendor/yiisoft/yii/framework';
require_once $yii1path . '/YiiBase.php';

spl_autoload_unregister(['YiiBase','autoload']);
spl_autoload_register(['Yii','autoload']);

Yii::$classMap = include($yii2path . '/classes.php');
Yii::registerAutoloader([BaseYii::class, 'autoload']);

Yii::$container = new yii\di\Container();
