<?php

namespace app\modules\ulogin;

use DWebModule;

class UloginModule extends DWebModule
{
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
