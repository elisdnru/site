<?php

namespace app\modules\admin;

use app\modules\main\components\system\DWebModule;

class AdminModule extends DWebModule
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
