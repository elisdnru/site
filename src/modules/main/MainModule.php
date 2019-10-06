<?php

namespace app\modules\main;

use app\components\system\WebModule;

class MainModule extends WebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public static function rules()
    {
        return [
            '' => 'main/default/index',
            '<action:error|url>' => 'main/default/<action>',
        ];
    }
}
