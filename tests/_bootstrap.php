<?php
// phpcs:disable
// PSR1.Files.SideEffects

require_once __DIR__ . '/../vendor/autoload.php';

defined('YII_ENABLE_EXCEPTION_HANDLER') or define('YII_ENABLE_EXCEPTION_HANDLER', false);
defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER', false);

require_once __DIR__ . '/../config/env.php';
require_once __DIR__ . '/../bootstrap.php';

Yii::createWebApplication(__DIR__ . '/../config/v1/web-test.php');
