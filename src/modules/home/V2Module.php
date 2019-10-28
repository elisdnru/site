<?php

namespace app\modules\home;

use app\components\module\Module as Base;
use app\components\module\routes\UrlProvider;

class V2Module extends Base implements UrlProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public static function rules(): array
    {
        return [
            '' => 'home/default/index',
            'error' => 'home/default/error',
        ];
    }

    public static function rulesPriority(): int
    {
        return 100;
    }
}
