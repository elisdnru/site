<?php

namespace app\modules\main;

use app\components\module\Module as Base;

class Module extends Base
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public static function rules(): array
    {
        return [
            '' => 'main/default/index',
            'error' => 'main/default/error',
        ];
    }

    public static function rulesPriority(): int
    {
        return 100;
    }
}
