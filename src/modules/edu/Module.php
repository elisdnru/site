<?php

declare(strict_types=1);

namespace app\modules\edu;

use app\components\module\routes\RoutesProvider;
use Override;
use yii\base\Module as Base;
use yii\web\GroupUrlRule;

final class Module extends Base implements RoutesProvider
{
    #[Override]
    public static function routes(): array
    {
        return [
            [
                'class' => GroupUrlRule::class,
                'prefix' => 'edu',
                'rules' => [
                    '' => 'default/index',
                ],
            ],
        ];
    }

    #[Override]
    public static function routesPriority(): int
    {
        return 0;
    }
}
