<?php

declare(strict_types=1);

namespace app\modules\subscribe;

use app\components\module\routes\RoutesProvider;
use yii\base\Module as Base;
use yii\web\GroupUrlRule;

final class Module extends Base implements RoutesProvider
{
    public static function routes(): array
    {
        return [
            [
                'class' => GroupUrlRule::class,
                'prefix' => 'subscribe',
                'rules' => [
                    '' => 'default/index',
                    'activate' => 'default/activate',
                    'success' => 'default/success',
                ],
            ],
        ];
    }

    public static function routesPriority(): int
    {
        return 0;
    }
}
