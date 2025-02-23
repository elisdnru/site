<?php

declare(strict_types=1);

namespace app\components;

use Override;
use yii\base\ErrorException;
use yii\validators\ImageValidator as YiiImageValidator;

final class ImageValidator extends YiiImageValidator
{
    #[Override]
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
