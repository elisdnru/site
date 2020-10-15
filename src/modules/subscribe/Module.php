<?php

namespace app\modules\subscribe;

use app\components\module\routes\RoutesProvider;
use app\components\module\Module as Base;
use yii\web\GroupUrlRule;

class Module extends Base implements RoutesProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getName(): string
    {
        return 'Подписка';
    }

    public static function adminMenu(): array
    {
        return [];
    }

    public static function notifications(): array
    {
        return [];
    }

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
