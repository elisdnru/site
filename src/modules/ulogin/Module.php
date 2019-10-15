<?php

namespace app\modules\ulogin;

use app\components\module\Module as Base;

class Module extends Base
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public static function rules(): array
    {
        return [
            'ulogin' => 'ulogin/default/login',
        ];
    }
}
