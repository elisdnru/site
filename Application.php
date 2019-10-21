<?php

declare(strict_types=1);

namespace yii\base;

use app\components\uploader\Uploader;
use app\extensions\file\File;
use app\extensions\image\ImageHandler;

/**
 * Autocomplete helper
 *
 * @property ImageHandler $image
 * @property File $file
 * @property Uploader $uploader
 */
abstract class Application
{

}
