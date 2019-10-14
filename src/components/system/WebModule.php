<?php

namespace app\components\system;

use CWebModule;

class WebModule extends CWebModule
{
    public function getGroup(): string
    {
        return 'Почее';
    }

    public static function adminMenu(): array
    {
        return [];
    }

    public static function notifications(): array
    {
        return [];
    }

    public static function rules(): array
    {
        return [];
    }
}
