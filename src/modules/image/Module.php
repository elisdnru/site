<?php

declare(strict_types=1);

namespace app\modules\image;

use app\components\module\routes\RoutesProvider;
use yii\base\Module as Base;

class Module extends Base implements RoutesProvider
{
    public static function routes(): array
    {
        return [
            'upload/<image:.+\/[a-f0-9]+_[0-9]+x[0-9]+\..+>' => 'image/download/thumb',
        ];
    }

    public static function routesPriority(): int
    {
        return 0;
    }
}
