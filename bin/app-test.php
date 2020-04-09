#!/usr/bin/env php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../config/env.php';
require_once __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/console-test.php';
$app = new yii\console\Application($config);
$app->run();
