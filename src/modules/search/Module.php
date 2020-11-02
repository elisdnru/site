<?php

namespace app\modules\search;

use app\components\module\routes\RoutesProvider;
use yii\base\Module as Base;

class Module extends Base implements RoutesProvider
{
    public static function routes(): array
    {
        return [
            'search' => 'search/default/index',
        ];
    }

    public static function routesPriority(): int
    {
        return 0;
    }
}
