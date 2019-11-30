<?php

namespace app\components;

use yii\helpers\Inflector;

class TextHelper
{
    public static function translit($string): string
    {
        return Inflector::transliterate($string);
    }

    public static function slug($string): string
    {
        return Inflector::slug($string);
    }

    public static function fixBR($text)
    {
        return preg_replace_callback('@(<p>.*?</p>)@s', static function ($matches): string {
            return nl2br($matches[0]);
        }, $text);
    }
}
