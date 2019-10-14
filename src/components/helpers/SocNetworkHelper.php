<?php

namespace app\components\helpers;

class SocNetworkHelper
{
    public static function getIcon(string $network): string
    {
        return '<span class="social-icon ' . $network . '"></span>';
    }
}
