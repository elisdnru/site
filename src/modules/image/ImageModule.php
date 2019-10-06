<?php

namespace app\modules\image;

use app\components\system\WebModule;

class ImageModule extends WebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public static function rules()
    {
        return [
            'upload/resize' => 'uploader/resize/index',
            'upload/images/<image:.+\/[a-f0-9]+_[0-9]+x[0-9]+\..+>' => 'uploader/download/thumb',
        ];
    }
}
