<?php

namespace app\components\helpers;

class SocNetworkHelper
{
    public static function getIcon($network): string
    {
        return '<span class="social-icon ' . $network . '"></span>';
    }
}
