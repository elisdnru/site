<?php
class SearchHighlighter
{
    public static function getFragment($text, $word){
        if ($word)
        {
            $pos = max(mb_stripos($text, $word, null, 'UTF-8') - 100, 0);
            $fragment = mb_substr($text, $pos, 200, 'UTF-8');
            $highlighted = str_ireplace($word, '<span class="highlight">' . $word . '</span>', $fragment);
        } else {
            $highlighted = mb_substr($text, 0, 200, 'UTF-8');
        }
        return trim($highlighted);
    }
}