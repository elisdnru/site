<?php
// phpcs:disable
// PSR1.Files.SideEffects

use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__.'/../vendor/autoload.php';

defined('YII_ENABLE_EXCEPTION_HANDLER') or define('YII_ENABLE_EXCEPTION_HANDLER', false);
defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER', false);

if (file_exists(__DIR__ . '/../.env')) {
    (new Dotenv())->load(__DIR__ . '/../.env');
}

require_once __DIR__.'/../config/env.php';

require_once __DIR__ . '/../bootstrap.php';

Yii::createWebApplication(__DIR__.'/../config/v1/test.php');

$config = require __DIR__ . '/../config/test.php';
new yii\web\Application($config);

Yii::import('system.test.CTestCase');
Yii::import('system.test.CDbTestCase');
Yii::import('system.test.CWebTestCase');

require_once(__DIR__.'/DbTestCase.php');
