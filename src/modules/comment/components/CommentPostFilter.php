<?php

declare(strict_types=1);

namespace app\modules\comment\components;

final class CommentPostFilter
{
    public function fixMarkup(?string $text): string
    {
        if ($text === null) {
            return '';
        }

        return preg_replace_callback('@(<p>.*?</p>)@s', static fn (array $matches): string => nl2br($matches[0]), $text);
    }
}
