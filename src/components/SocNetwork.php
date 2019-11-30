<?php

namespace app\components;

class SocNetwork
{
    public static function icon(string $network): string
    {
        return '<span class="social-icon ' . $network . '"></span>';
    }
}
