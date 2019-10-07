<?php

namespace app\modules\main;

use app\components\system\WebModule;

class Module extends WebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public static function rules()
    {
        return [
            '' => 'main/default/index',
            'error' => 'main/default/error',
        ];
    }
}
