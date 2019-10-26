<?php

namespace app\modules\main;

use app\components\module\routes\UrlProvider;
use CWebModule;

class Module extends CWebModule implements UrlProvider
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
