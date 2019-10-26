<?php

namespace app\modules\admin;

use app\components\module\Module as Base;
use app\components\module\routes\UrlProvider;
use yii\web\GroupUrlRule;

class V2Module extends Base implements UrlProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getName(): string
    {
        return 'Панель управления';
    }

    public static function rules(): array
    {
        return [
            [
                'class' => GroupUrlRule::class,
                'prefix' => 'admin',
                'rules' => [
                    'cache/clear' => 'cache/clear',
                    '' => 'default/index',
                ],
            ],
        ];
    }

    public static function rulesPriority(): int
    {
        return 0;
    }
}
