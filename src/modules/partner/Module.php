<?php

declare(strict_types=1);

namespace app\modules\partner;

use app\components\module\routes\RoutesProvider;
use Override;
use yii\base\Module as Base;

final class Module extends Base implements RoutesProvider
{
    #[Override]
    public static function routes(): array
    {
        return [
            'partner' => 'partner/default/index',
        ];
    }

    #[Override]
    public static function routesPriority(): int
    {
        return 0;
    }
}
