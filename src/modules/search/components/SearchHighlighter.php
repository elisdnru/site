<?php

namespace app\modules\search\components;

class SearchHighlighter
{
    public static function getFragment(?string $text, ?string $word): string
    {
        if ($text === null) {
            return '';
        }
        if ($word) {
            $pos = max((int)mb_stripos($text, $word, null, 'UTF-8') - 100, 0);
            $fragment = mb_substr($text, $pos, 200, 'UTF-8');
            $highlighted = str_ireplace($word, '<mark>' . $word . '</mark>', $fragment);
        } else {
            $highlighted = mb_substr($text, 0, 200, 'UTF-8');
        }
        return trim($highlighted);
    }
}
