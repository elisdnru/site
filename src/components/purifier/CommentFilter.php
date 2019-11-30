<?php

namespace app\components\purifier;

class CommentFilter
{
    public static function fixMarkup(?string $text)
    {
        return preg_replace_callback('@(<p>.*?</p>)@s', static function ($matches): string {
            return nl2br($matches[0]);
        }, $text);
    }
}
