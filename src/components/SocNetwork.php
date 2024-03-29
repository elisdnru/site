<?php

declare(strict_types=1);

namespace app\components;

final class SocNetwork
{
    public static function icon(string $network): string
    {
        return '<span class="social-icon ' . $network . '"></span>';
    }
}
