<?php

namespace app\components;

use yii\helpers\Inflector;

class Slugger
{
    public static function slug(string $string): string
    {
        return Inflector::slug($string);
    }
}
