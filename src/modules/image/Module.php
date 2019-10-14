<?php

namespace app\modules\image;

use app\components\system\WebModule;

class Module extends WebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public static function rules(): array
    {
        return [
            'upload/<image:.+\/[a-f0-9]+_[0-9]+x[0-9]+\..+>' => 'image/download/thumb',
        ];
    }
}
