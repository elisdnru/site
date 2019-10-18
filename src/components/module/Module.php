<?php

namespace app\components\module;

use CWebModule;

class Module extends CWebModule
{
    public function getGroup(): string
    {
        return 'Прочее';
    }

    public static function adminMenu(): array
    {
        return [];
    }

    public static function notifications(): array
    {
        return [];
    }
}
