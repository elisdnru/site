<?php

error_reporting(-1);

require_once(dirname(__FILE__).'/protected/components/DTimer.php');
DTimer::run();

// change the following paths if necessary
$yii=dirname(__FILE__).'/../../localhost/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/local_fishing.php';

defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();


