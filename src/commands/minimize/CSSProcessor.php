<?php

declare(strict_types=1);

namespace app\commands\minimize;

use app\commands\minimize;

class CSSProcessor implements minimize\TextProcessor
{
    public function process($text)
    {
        $text = preg_replace('#[\s\t\r\n]+#s', ' ', $text);
        $text = preg_replace('#/\*.*?\*/\s*#s', '', $text);
        $text = preg_replace('#\}\s*#s', "}\n", $text);
        $text = preg_replace('#\n+#s', "\n", $text);
        return $text;
    }
}
