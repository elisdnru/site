<?php

namespace app\modules\page;

use app\components\module\routes\UrlProvider;
use CWebModule;

class Module extends CWebModule implements UrlProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public static function rules(): array
    {
        return [
            'page/page/show' => 'site/error',
            'page/page' => 'site/error',
            ['class' => components\PageUrlRule::class, 'cache' => 3600 * 24],
        ];
    }

    public static function rulesPriority(): int
    {
        return -1;
    }
}
