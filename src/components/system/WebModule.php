<?php

namespace app\components\system;

use CWebModule;

class WebModule extends CWebModule
{
    public function getGroup()
    {
        return 'Почее';
    }

    public static function adminMenu()
    {
        return [];
    }

    public static function notifications()
    {
        return [];
    }
}
