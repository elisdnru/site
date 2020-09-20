<?php

namespace app\components\purifier;

class CommentPostFilter
{
    public static function fixMarkup(?string $text): ?string
    {
        return preg_replace_callback('@(<p>.*?</p>)@s', static function ($matches): string {
            return nl2br($matches[0]);
        }, $text);
    }
}
