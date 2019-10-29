<?php

namespace app\modules\ulogin;

use app\components\module\routes\UrlProvider;
use yii\base\Module as Base;

class Module extends Base implements UrlProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public static function rules(): array
    {
        return [
            'ulogin' => 'ulogin/default/login',
        ];
    }

    public static function rulesPriority(): int
    {
        return 0;
    }
}
