<?php

namespace app\modules\ulogin;

use app\modules\main\components\system\WebModule;

class UloginModule extends WebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function init()
    {
        parent::init();

        $this->setImport([
            'application.modules.ulogin.components.*',
            'application.modules.ulogin.models.*',
        ]);
    }

    public static function rules()
    {
        return [
            'ulogin' => 'ulogin/default/login',
        ];
    }
}
