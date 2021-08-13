<?php

declare(strict_types=1);

namespace app\components;

use yii\helpers\Inflector;

final class Slugger
{
    public static function slug(string $string): string
    {
        return Inflector::slug($string);
    }
}
