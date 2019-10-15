<?php

namespace app\modules\admin;

use app\components\GroupUrlRule;
use app\components\module\Module as Base;

class Module extends Base
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
}
