<?php

declare(strict_types=1);

namespace app\modules\services;

use app\components\module\routes\RoutesProvider;
use yii\base\Module as Base;

final class Module extends Base implements RoutesProvider
{
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
