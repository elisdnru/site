<?php

namespace app\components;

class SocNetworkHelper
{
    public static function getIcon(string $network): string
    {
        return '<span class="social-icon ' . $network . '"></span>';
    }
}
