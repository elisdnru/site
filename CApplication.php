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
 * @property \app\extensions\email\Email $email
 * @property CHttpSession $session
 * @property \app\components\module\ModuleManager $moduleManager
 * @property \app\components\uploader\UploadManager $uploader
 * @property \app\extensions\file\CFile $file
 * @property \app\extensions\image\CImageHandler $image
 * @property CWidgetFactory $widgetFactory
 * @property ICache|TaggingBehavior $cache
 * @property CTextHighlighter $syntaxhighlighter
 */
abstract class CApplication
{

}
