<?php

namespace app\modules\services;

use app\components\module\routes\RoutesProvider;
use app\components\module\Module as Base;

class Module extends Base implements RoutesProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getName(): string
    {
        return 'Услуги';
    }

    public static function routes(): array
    {
        return [
            'services' => 'services/default/index',
        ];
    }

    public static function routesPriority(): int
    {
        return 0;
    }
}
