<?php

declare(strict_types=1);

namespace app\components;

use yii\base\ErrorException;
use yii\validators\ImageValidator as YiiImageValidator;

class ImageValidator extends YiiImageValidator
{
    protected function validateImage($image): ?array
    {
        try {
            return parent::validateImage($image);
        } catch (ErrorException $e) {
            if ($e->getMessage() === 'getimagesize(): Read error!') {
                return [$this->notImage, ['file' => $image->name]];
            }
            throw $e;
        }
    }
}
