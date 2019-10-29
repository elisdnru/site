<?php

namespace app\modules\landing;

use app\components\module\routes\UrlProvider;
use CWebModule;

class Module extends CWebModule implements UrlProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public static function rules(): array
    {
        return [
            ['class' => components\v1\LandingUrlRule::class, 'cache' => 3600 * 24],
        ];
    }

    public static function rulesPriority(): int
    {
        return -1;
    }
}
