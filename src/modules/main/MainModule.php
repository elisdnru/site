<?php

namespace app\modules\main;

use app\modules\main\components\system\DWebModule;

class MainModule extends DWebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public static function rules()
    {
        return [
            '' => 'main/default/index',
            'js/config.js' => 'main/default/configjs',
            '<action:error|url>' => 'main/default/<action>',
        ];
    }
}
