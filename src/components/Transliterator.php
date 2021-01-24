<?php

namespace app\components;

use yii\helpers\Inflector;

class Transliterator
{
    public static function translit(string $string): string
    {
        return Inflector::transliterate($string);
    }
}
