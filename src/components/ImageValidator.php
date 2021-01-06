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
            if (str_starts_with($e->getMessage(), 'getimagesize(): Error reading from ')) {
                return [$this->notImage, ['file' => $image->name]];
            }
            throw $e;
        }
    }
}
