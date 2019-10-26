<?php

namespace app\modules\image;

use app\components\module\Module as Base;
use app\components\module\routes\UrlProvider;

class V2Module extends Base implements UrlProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public static function rules(): array
    {
        return [
            'upload/<image:.+\/[a-f0-9]+_[0-9]+x[0-9]+\..+>' => 'image/download/thumb',
        ];
    }

    public static function rulesPriority(): int
    {
        return 0;
    }
}
