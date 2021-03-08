<?php

namespace app\components\purifier;

class CommentPostFilter
{
    public static function fixMarkup(?string $text): ?string
    {
        if ($text === null) {
            return null;
        }

        return preg_replace_callback('@(<p>.*?</p>)@s', static function (array $matches): string {
            return nl2br((string)$matches[0]);
        }, $text);
    }
}
