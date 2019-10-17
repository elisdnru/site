<?php

namespace app\components\helpers;

use yii\helpers\Inflector;

class TextHelper
{
    public static function translit($string): string
    {
        return Inflector::transliterate($string);
    }

    public static function strToChpu($string): string
    {
        return Inflector::slug($string);
    }

    public static function firstWord($str)
    {
        $words = explode(' ', $str);
        return $words[0] ?? '';
    }

    public static function fixBR($text)
    {
        $text = preg_replace_callback('@(<p>.*?</p>)@s', [self::class, 'pregCallback'], $text);
        return $text;
    }

    protected static function pregCallback($matches): string
    {
        return nl2br($matches[0]);
    }
}
