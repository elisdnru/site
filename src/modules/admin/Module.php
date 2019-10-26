<?php

namespace app\modules\admin;

use app\components\GroupUrlRule;
use app\components\module\routes\UrlProvider;
use CWebModule;

class Module extends CWebModule implements UrlProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public static function rules(): array
    {
        return [
            [
                'class' => GroupUrlRule::class,
                'prefix' => 'admin',
                'rules' => [
                    'cache/clear' => 'cache/clear',
                    '' => 'default/index',
                ],
            ],
        ];
    }

    public static function rulesPriority(): int
    {
        return 0;
    }
}
