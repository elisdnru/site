<?php

namespace app\modules\edu;

use app\components\module\routes\RoutesProvider;
use app\components\module\Module as Base;
use yii\web\GroupUrlRule;

class Module extends Base implements RoutesProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getName(): string
    {
        return 'База знаний';
    }

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
