<?php

namespace app\modules\admin;

use app\components\system\WebModule;

class Module extends WebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getName()
    {
        return 'Панель управления';
    }

    public static function rules()
    {
        return [
            'admin/clearCache' => 'admin/default/clearCache',
            'admin' => 'admin/default/index',
        ];
    }
}
