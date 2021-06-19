<?php

declare(strict_types=1);

namespace app\modules\edu;

use app\components\module\routes\RoutesProvider;
use yii\base\Module as Base;
use yii\web\GroupUrlRule;

class Module extends Base implements RoutesProvider
{
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

    public static function routesPriority(): int
    {
        return 0;
    }
}
