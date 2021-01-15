<?php

defined('YII_DEBUG') or define('YII_DEBUG', (bool)getenv('APP_DEBUG'));
defined('YII_ENV') or define('YII_ENV', getenv('APP_ENV'));
defined('YII_ENV_TEST') or define('YII_ENV_TEST', getenv('APP_ENV') === 'test');
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
