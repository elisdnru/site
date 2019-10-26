<?php

namespace app\modules\contact;

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
                'prefix' => 'contact',
                'rules' => [
                    'captcha' => 'default/captcha',
                ],
            ],
        ];
    }

    public static function rulesPriority(): int
    {
        return 0;
    }
}
