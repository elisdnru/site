<?php

namespace app\modules\ulogin;

use app\components\module\routes\RoutesProvider;
use yii\base\Module as Base;

class Module extends Base implements RoutesProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public static function routes(): array
    {
        return [
            'ulogin' => 'ulogin/default/login',
        ];
    }

    public static function routesPriority(): int
    {
        return 0;
    }
}
