<?php

declare(strict_types=1);

namespace app\components;

class StyleHelper
{
    public static function minimize(?string $css): string
    {
        return preg_replace('#\s+#', ' ', $css);
    }
}