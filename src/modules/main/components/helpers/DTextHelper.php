<?php

/*
 * Do not convert encoding of this file! Only cp-1251!
 *

 */

namespace app\modules\main\components\helpers;

class DTextHelper
{
    public static function translit($st)
    {
        $st = iconv('UTF-8', 'windows-1251', $st);
        $st = strtr($st, '�����������������������', 'abvgdeeziyklmnoprstufhie');
        $st = strtr($st, '�����Ũ�����������������', 'ABVGDEEZIYKLMNOPRSTUFHIE');
        $st = strtr(
            $st,
            [

                '�' => 'zh', '�' => 'ts', '�' => 'ch', '�' => 'sh',

                '�' => 'shch', '�' => '', '�' => '', '�' => 'yu', '�' => 'ya',

                '�' => 'ZH', '�' => 'TS', '�' => 'CH', '�' => 'SH',

                '�' => 'SHCH', '�' => '', '�' => '', '�' => 'YU', '�' => 'YA',

                '�' => 'i', '�' => 'Yi', '�' => 'ie', '�' => 'Ye'

            ]
        );
        $st = iconv('windows-1251', 'UTF-8', $st);
        return $st;
    }

    public static function strToChpu($str)
    {
        $s = self::translit($str);
        $s = iconv('UTF-8', 'windows-1251', $s);
        $s = str_replace([' ', '_', '�', '.', ',', ':', ';', '+', '/', '|', '=', "\\"], '-', $s);
        $s = str_replace(['&', '!', '?', '�', '�', '"', "'", '(', ')'], '', $s);
        $s = str_replace('---', '-', $s);
        $s = str_replace('--', '-', $s);
        $s = str_replace('--', '-', $s);
        $s = trim($s, '-');
        $s = iconv('windows-1251', 'UTF-8', $s);
        return $s;
    }

    public static function firstWord($str)
    {
        $words = explode(' ', $str);
        return isset($words[0]) ? $words[0] : '';
    }

    public static function fixBR($text)
    {
        $text = preg_replace_callback('@(<p>.*?</p>)@s', ['app\modules\main\components\helpers\DTextHelper', 'pregCallback'], $text);
        return $text;
    }

    protected static function pregCallback($matches)
    {
        return nl2br($matches[0]);
    }
}
