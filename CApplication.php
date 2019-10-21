<?php

declare(strict_types=1);

use app\extensions\cachetagging\TaggingBehavior;

/**
 * Autocomplete helper
 *
 * @property CClientScript $clientScript
 * @property \app\components\PhpAuthManager authManager
 * @property \app\modules\user\components\WebUser $user
 * @property \app\components\Controller $controller
 * @property CHttpSession $session
 * @property \app\components\module\ModuleManager $moduleManager
 * @property ICache|TaggingBehavior $cache
 * @property CTextHighlighter $syntaxhighlighter
 */
abstract class CApplication
{

}
