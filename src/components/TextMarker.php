<?php

declare(strict_types=1);

namespace app\components;

class TextMarker
{
    public static function markFragment(?string $text, ?string $needle, int $range = 200): string
    {
        if ($text === null) {
            return '';
        }
        if ($needle) {
            $pos = max((int)mb_stripos($text, $needle, 0, 'UTF-8') - 100, 0);
            $fragment = mb_substr($text, $pos, $range, 'UTF-8');
            $highlighted = str_ireplace($needle, '<mark>' . $needle . '</mark>', $fragment);
        } else {
            $highlighted = mb_substr($text, 0, $range, 'UTF-8');
        }
        return trim($highlighted);
    }
}
