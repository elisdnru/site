<?php

namespace app\modules\partner;

use app\components\module\routes\RoutesProvider;
use yii\base\Module as Base;

class Module extends Base implements RoutesProvider
{
    public static function routes(): array
    {
        return [
            'partner' => 'partner/default/index',
        ];
    }

    public static function routesPriority(): int
    {
        return 0;
    }
}
