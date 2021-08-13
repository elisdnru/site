<?php

declare(strict_types=1);

namespace app\components;

final class CSSMinimizer
{
    public static function minimize(?string $css): string
    {
        return preg_replace('#\s+#', ' ', $css ?: '');
    }
}
