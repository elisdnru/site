<?php

namespace app\components\module\v2;

use yii\base\Module as Base;

class Module extends Base
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
