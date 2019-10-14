<?php

namespace app\modules\ulogin;

use app\components\system\WebModule;

class Module extends WebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public static function rules(): array
    {
        return [
            'ulogin' => 'ulogin/default/login',
        ];
    }
}
