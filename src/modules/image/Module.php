<?php

declare(strict_types=1);

namespace app\modules\image;

use app\components\module\routes\RoutesProvider;
use Override;
use yii\base\Module as Base;

final class Module extends Base implements RoutesProvider
{
    #[Override]
    public static function routes(): array
    {
        return [
            'upload/<image:.+\/[a-f0-9]+_[0-9]+x[0-9]+\..+>' => 'image/download/thumb',
        ];
    }

    #[Override]
    public static function routesPriority(): int
    {
        return 0;
    }
}
