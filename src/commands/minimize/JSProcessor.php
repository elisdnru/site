<?php

declare(strict_types=1);

namespace app\commands\minimize;

use app\commands\minimize;

class JSProcessor implements minimize\TextProcessor
{
    public function process($text)
    {
        $text = preg_replace('#[\r\n]+#s', "\n", $text);
        $text = preg_replace('#\t\n+#s', "\n", $text);
        $text = preg_replace('#\n+#s', "\n", $text);
        $text = preg_replace('#\n\s+#s', "\n", $text);
        return $text;
    }
}
