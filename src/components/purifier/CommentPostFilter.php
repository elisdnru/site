<?php

declare(strict_types=1);

namespace app\components\purifier;

final class CommentPostFilter
{
    public static function fixMarkup(?string $text): ?string
    {
        if ($text === null) {
            return null;
        }

        return preg_replace_callback('@(<p>.*?</p>)@s', static fn (array $matches): string => nl2br($matches[0]), $text);
    }
}
