<?php

namespace app\modules\user;

use app\components\module\routes\UrlProvider;
use CWebModule;

class Module extends CWebModule implements UrlProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public static function rules(): array
    {
        return [
            '<action:login|logout|relogin|remind>' => 'user/default/<action>',
            'registration' => 'user/registration/request',
            'registration/confirm' => 'user/registration/confirm',
            'registration/captcha' => 'user/registration/captcha',
            'profile' => 'user/profile/view',
            'profile/edit' => 'user/profile/edit',
        ];
    }

    public static function rulesPriority(): int
    {
        return 99;
    }
}
