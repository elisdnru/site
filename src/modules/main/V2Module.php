<?php

namespace app\modules\main;

use app\components\module\Module as Base;
use app\components\module\routes\UrlProvider;

class V2Module extends Base implements UrlProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public static function rules(): array
    {
        return [
            '' => 'main/default/index',
            'error' => 'main/default/error',
        ];
    }

    public static function rulesPriority(): int
    {
        return 100;
    }
}
