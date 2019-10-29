<?php

namespace app\modules\search;

use app\components\module\routes\UrlProvider;
use yii\base\Module as Base;

class Module extends Base implements UrlProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public static function rules(): array
    {
        return [
            'search' => 'search/default/index',
        ];
    }

    public static function rulesPriority(): int
    {
        return 0;
    }
}
