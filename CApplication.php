<?php

declare(strict_types=1);

use app\components\module\ModuleManager;
use app\components\PhpAuthManager;
use app\extensions\cachetagging\TaggingBehavior;
use app\modules\user\components\WebUser;

/**
 * Autocomplete helper
 *
 * @property CClientScript $clientScript
 * @property PhpAuthManager authManager
 * @property WebUser $user
 * @property \app\components\Controller $controller
 * @property CHttpSession $session
 * @property ModuleManager $moduleManager
 * @property ICache|TaggingBehavior $cache
 * @property CTextHighlighter $syntaxhighlighter
 */
abstract class CApplication
{

}
