<?php

declare(strict_types=1);

use app\components\UserAuthManager;
use app\extensions\cachetagging\TaggingBehavior;

/**
 * Autocomplete helper
 *
 * @property UserAuthManager authManager
 * @property \CWebUser $user
 * @property \app\components\Controller $controller
 * @property CHttpSession $session
 * @property ICache|TaggingBehavior $cache
 * @property CTextHighlighter $syntaxhighlighter
 */
abstract class CApplication
{

}
