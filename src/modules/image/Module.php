<?php

namespace app\modules\image;

use app\components\GroupUrlRule;
use app\components\system\WebModule;

class Module extends WebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public static function rules()
    {
        return [
            [
                'class' => GroupUrlRule::class,
                'prefix' => 'upload',
                'routePrefix' => 'image',
                'rules' => [
                    'resize' => 'resize/index',
                    'images/<image:.+\/[a-f0-9]+_[0-9]+x[0-9]+\..+>' => 'download/thumb',
                ],
            ],
        ];
    }
}
